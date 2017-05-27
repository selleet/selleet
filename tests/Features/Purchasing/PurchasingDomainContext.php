<?php

namespace SelleetTest\Features\Purchasing;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\Assert;
use Selleet\Domain\Jewelry\Purchasing\Cart\Cart;
use Selleet\Domain\Jewelry\Purchasing\Cart\CartId;
use Selleet\Domain\Jewelry\Purchasing\Cart\EmptyCartWasPickedUp;
use Selleet\Domain\Jewelry\Purchasing\Jewel\Jewel;
use Selleet\Domain\Jewelry\Purchasing\Jewel\JewelId;
use Selleet\Domain\Jewelry\Purchasing\Jewel\NewJewelWasOut;

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
            new EmptyCartWasPickedUp(CartId::generate())
        ]);
    }

    /**
     * @Given a jewel titled :jewelTitle and priced :jewelPrice€ is available on the store
     */
    public function aJewelTitledAndPricedEurIsAvailableOnTheStore(string $jewelTitle, int $jewelPrice)
    {
        $this->jewel = Jewel::reconstituteFromHistory([
            new NewJewelWasOut(JewelId::generate(), $jewelTitle, $jewelPrice)
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
