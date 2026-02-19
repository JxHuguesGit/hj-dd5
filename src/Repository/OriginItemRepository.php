<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\OriginItem;

class OriginItemRepository extends Repository implements OriginItemRepositoryInterface
{
    public const TABLE = Table::ORIGINITEM;

    public function getEntityClass(): string
    {
        return OriginItem::class;
    }
}
