<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Item as DomainItem;

class ItemRepository extends Repository implements ItemRepositoryInterface
{
    public const TABLE = Table::ITEM;
    
    public function getEntityClass(): string
    {
        return DomainItem::class;
    }
}
