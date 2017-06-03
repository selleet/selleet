<?php

namespace Selleet\Purchasing\App\Cart;

use Selleet\BuildingBlocks\Command\Command;
use Selleet\BuildingBlocks\Command\CommandHandler;
use Selleet\Purchasing\Domain\Cart\CartRepository;

final class AddJewelToCartHandler implements CommandHandler
{
    private $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param AddJewelToCart $command
     *
     * @return DomainEvent[]
     */
    public function __invoke(Command $command): array
    {
        $cart = $this->cartRepository->get($command->cartId);

        $cart = $cart->add($command->jewelId, $command->price);

        $this->cartRepository->save($cart);

        return $cart->getRecordedEvents();
    }
}
