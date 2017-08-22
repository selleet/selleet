<?php

namespace Selleet\Purchasing\Container\Infrastructure\EventStore;

use Psr\Container\ContainerInterface;
use Selleet\BuildingBlocks\EventStore\EventBus;
use Selleet\Purchasing\Domain\Jewel\NewJewelWasOut;

class EventBusFactory
{
    public function __invoke(ContainerInterface $container): EventBus
    {
        $eventBus = new EventBus();
        $eventBus->attachListener(NewJewelWasOut::class, function (NewJewelWasOut $newJewelWasOut) {
        });

        return $eventBus;
    }
}
