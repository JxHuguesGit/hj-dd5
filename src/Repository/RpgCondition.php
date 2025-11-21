<?php
namespace src\Repository;

use src\Entity\RpgCondition as EntityRpgCondition;

class RpgCondition extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgCondition::class;
    }
}
