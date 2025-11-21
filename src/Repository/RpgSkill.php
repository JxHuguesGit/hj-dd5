<?php
namespace src\Repository;

use src\Entity\RpgSkill as EntityRpgSkill;

class RpgSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgSkill::class;
    }
}
