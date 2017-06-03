<?php

namespace Selleet\Purchasing\Domain\Jewel;

interface JewelRepository
{
    public function get(JewelId $jewelId): Jewel;

    public function save(Jewel $jewel): void;
}
