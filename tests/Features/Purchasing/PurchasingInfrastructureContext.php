<?php

namespace SelleetTest\Features\Purchasing;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Selleet\Domain\Jewelry\Purchasing\Cart\AddJewelToCart;
use Selleet\Domain\Jewelry\Purchasing\Cart\Cart;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartRepository;
use Selleet\Domain\Jewelry\Purchasing\Jewel\Jewel;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelRepository;
use Selleet\Infrastructure\BuildingBlocks\Bus\CommandBus;
use Zend\ServiceManager\ServiceManager;

class PurchasingInfrastructureContext implements Context
{
    /**
     * @var ServiceManager
     */
    private $container;
    /**
     * @var CartRepository
     */
    private $cartRepository;
    /**
     * @var JewelRepository
     */
    private $jewelRepository;
    /**
     * @var CommandBus
     */
    private $commandBus;
    private $cartId;
    private $jewelId;

    public function __construct()
    {
        $containerConfig = require __DIR__.'/../../../config/container.php';
        $this->container = new ServiceManager($containerConfig);
        $this->cartRepository = $this->container->get(CartRepository::class);
        $this->jewelRepository = $this->container->get(JewelRepository::class);
        $this->commandBus = $this->container->get(CommandBus::class);
    }

    /**
     * @Given I have an empty cart
     */
    public function iHaveAnEmptyCart()
    {
        $this->cartId = CartId::generate();

        $this->cartRepository->save(
            Cart::pickUp($this->cartId)
        );
    }

    /**
     * @Given a jewel titled :jewelTitle and priced :jewelPrice€ is available on the store
     */
    public function aJewelTitledAndPricedEurIsAvailableOnTheStore(string $jewelTitle, int $jewelPrice)
    {
        $this->jewelId = JewelId::generate();

        $this->jewelRepository->save(Jewel::titledAndPriced($this->jewelId, $jewelTitle, $jewelPrice));
    }

    /**
     * @When I add the jewel to my cart
     */
    public function iAddTheJewelToMyCart()
    {
        $this->commandBus->dispatch(new AddJewelToCart($this->cartId, $this->jewelId, 100));
    }

    /**
     * @Then the total of my cart should be :totalPrice€
     */
    public function theTotalOfMyCartShouldBeEur(int $totalPrice)
    {
        $cart = $this->cartRepository->get($this->cartId);

        Assert::assertSame($cart->totalPrice(), $totalPrice);
    }
}
