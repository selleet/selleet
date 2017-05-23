<?php

namespace SelleetTest\Purchasing;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\Assert;
use Selleet\Domain\Jewelry\Purchasing\Cart;
use Selleet\Domain\Jewelry\Purchasing\Jewel;
use Selleet\Domain\Jewelry\Purchasing\JewelId;

class ShoppingContext implements Context
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
        $this->cart = Cart::pickUp();
    }

    /**
     * @Given a jewel titled :jewelTitle and priced :jewelPrice€ is available on the store
     */
    public function aJewelTitledAndPricedEurIsAvailableOnTheStore(string $jewelTitle, int $jewelPrice)
    {
        $this->jewel = Jewel::titledAndPriced(JewelId::generate(), $jewelTitle, $jewelPrice);
    }

    /**
     * @When I add the jewel to my cart
     */
    public function iAddTheJewelToMyCart()
    {
        $this->cart->add($this->jewel);
    }

    /**
     * @Then the total of my cart should be :totalPrice€
     */
    public function theTotalOfMyCartShouldBeEur(int $totalPrice)
    {
        Assert::assertSame($this->cart->totalPrice(), $totalPrice);
    }
}
