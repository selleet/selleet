<?php

namespace SelleetTest\Features\Purchasing;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Selleet\Purchasing\Domain\Cart\Cart;
use Selleet\Purchasing\Domain\Cart\CartId;
use Selleet\Purchasing\Domain\Cart\EmptyCartWasPickedUp;
use Selleet\Purchasing\Domain\Jewel\Jewel;
use Selleet\Purchasing\Domain\Jewel\JewelId;
use Selleet\Purchasing\Domain\Jewel\NewJewelWasOut;

class PurchasingDomainContext implements Context
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var Jewel
     */
    private $jewel;

    /**
     * @Given I have an empty cart
     */
    public function iHaveAnEmptyCart()
    {
        $this->cart = Cart::reconstituteFromHistory([
            new EmptyCartWasPickedUp(CartId::generate()),
        ]);
    }

    /**
     * @Given a jewel titled :jewelTitle and priced :jewelPrice€ is available on the store
     */
    public function aJewelTitledAndPricedEurIsAvailableOnTheStore(string $jewelTitle, int $jewelPrice)
    {
        $this->jewel = Jewel::reconstituteFromHistory([
            new NewJewelWasOut(JewelId::generate(), $jewelTitle, $jewelPrice),
        ]);
    }

    /**
     * @When I add the jewel to my cart
     */
    public function iAddTheJewelToMyCart()
    {
        $this->cart = $this->cart->add($this->jewel->getAggregateId(), $this->jewel->price());
    }

    /**
     * @Then the total of my cart should be :totalPrice€
     */
    public function theTotalOfMyCartShouldBeEur(int $totalPrice)
    {
        Assert::assertSame($this->cart->totalPrice(), $totalPrice);
    }
}
