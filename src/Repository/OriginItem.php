<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\OriginItem as DomainOriginItem;

class OriginItem extends Repository
{
    public const TABLE = Table::ORIGINITEM;
    
    public function getEntityClass(): string
    {
        return DomainOriginItem::class;
    }
}
