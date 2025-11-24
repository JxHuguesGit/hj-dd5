<?php
namespace src\Repository;

use src\Entity\RpgTool as EntityRpgTool;

class RpgTool extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTool::class;
    }
}
