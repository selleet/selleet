<?php

namespace Selleet\Purchasing\Infrastructure\Jewel;

use Selleet\Purchasing\Domain\Jewel\NewJewelWasOut;

final class JewelMysqlProjector
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
            NewJewelWasOut::class => function (NewJewelWasOut $event) {
                $sql = <<<SQL
INSERT INTO `jewel` (`id`, `title`, `price`, `created_at`)
VALUES (:jewel_id, :title, :price, :created_at);
SQL;

                $stmt = $this->mysqlReadRepository->prepare($sql);

                $stmt->bindValue('jewel_id', $event->getAggregateId()->toString());
                $stmt->bindValue('title', $event->getTitle());
                $stmt->bindValue('price', $event->getPrice());
                $stmt->bindValue('created_at', $event->getDateTime()->format('Y-m-d H:i:s'));

                $stmt->execute();
            },
        ];
    }
}
