<?php

namespace Selleet\Purchasing\Infrastructure\Cart;

use Selleet\Purchasing\Domain\Cart\EmptyCartWasPickedUp;
use Selleet\Purchasing\Domain\Cart\JewelWasAddedToCart;

final class CartMysqlProjector
{
    /**
     * @var \PDO
     */
    private $mysqlReadRepository;

    public function __construct(\PDO $mysqlReadRepository)
    {
        $this->mysqlReadRepository = $mysqlReadRepository;
    }

    public function __invoke(): array
    {
        return [
            EmptyCartWasPickedUp::class => function (EmptyCartWasPickedUp $event) {
                $sql = <<<SQL
INSERT INTO `cart` (`id`, `created_at`)
VALUES (:cart_id, :created_at);
SQL;
                $stmt = $this->mysqlReadRepository->prepare($sql);
                $stmt->bindValue('cart_id', $event->getAggregateId()->toString());
                $stmt->bindValue('created_at', $event->getDateTime()->format('Y-m-d H:i:s'));
                $stmt->execute();
            },
            JewelWasAddedToCart::class => function (JewelWasAddedToCart $event) {
                $sql = <<<SQL
UPDATE cart_has_jewels
SET nb_items = nb_items + 1
WHERE cart_has_jewels.id_cart = :id_cart AND cart_has_jewels.id_jewel = :id_jewel;
SQL;
                $stmt = $this->mysqlReadRepository->prepare($sql);
                $stmt->bindValue('id_cart', $event->getAggregateId()->toString());
                $stmt->bindValue('id_jewel', $event->getJewelId()->toString());
                $stmt->execute();

                if ($stmt->rowCount() === 0) {
                    $sql = <<<SQL
INSERT INTO `cart_has_jewels` (`id_cart`, `id_jewel`, `nb_items`)
VALUES (:id_cart, :id_jewel, :nb_items);
SQL;
                    $stmt = $this->mysqlReadRepository->prepare($sql);
                    $stmt->bindValue('id_cart', $event->getAggregateId()->toString());
                    $stmt->bindValue('id_jewel', $event->getJewelId()->toString());
                    $stmt->bindValue('nb_items', 1);
                    $stmt->execute();
                }
            },
        ];
    }
}
