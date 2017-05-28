<?php

namespace SelleetTest\Infrastructure\BuildingBlocks\Bus;

use Selleet\Domain\BuildingBlocks\Command\Command;

final class TestCommand implements Command
{
    public $test;
}
