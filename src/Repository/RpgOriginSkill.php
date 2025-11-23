<?php
namespace src\Repository;

use src\Entity\RpgOriginSkill as EntityRpgOriginSkill;

class RpgOriginSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgOriginSkill::class;
    }
}
