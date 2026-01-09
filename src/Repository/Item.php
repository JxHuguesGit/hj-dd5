<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Item as DomainItem;

class Item extends Repository
{
    public const TABLE = Table::ITEM;
    
    public function getEntityClass(): string
    {
        return DomainItem::class;
    }
}
