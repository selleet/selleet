<?php

namespace Selleet\Domain\Jewelry\Purchasing;

final class Jewel
{
    private $id;
    private $title;
    private $price;

    private function __construct(JewelId $id, string $title, int $price) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
    }

    public static function titledAndPriced(JewelId $id, string $title, int $price): self
    {
        return new self($id, $title, $price);
    }

    public function price(): int
    {
        return $this->price;
    }
}
