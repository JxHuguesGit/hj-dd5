<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgTool as DomainRpgTool;

class RpgTool extends Repository
{
    public const TABLE = Table::TOOL;
    
    public function getEntityClass(): string
    {
        return DomainRpgTool::class;
    }
}
