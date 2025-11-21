<?php
namespace src\Repository;

use src\Entity\RpgMonsterSkill as EntityRpgMonsterSkill;

class RpgMonsterSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterSkill::class;
    }
}
