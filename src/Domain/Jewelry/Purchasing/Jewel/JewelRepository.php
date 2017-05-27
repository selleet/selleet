<?php

namespace Selleet\Domain\Jewelry\Purchasing\Jewel;

interface JewelRepository
{
    public function get(JewelId $jewelId): Jewel;

    public function save(Jewel $jewel): void;
}
