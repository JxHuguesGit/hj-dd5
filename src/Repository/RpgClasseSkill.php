<?php
namespace src\Repository;

use src\Entity\RpgClasseSkill as EntityRpgClasseSkill;

class RpgClasseSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgClasseSkill::class;
    }
}
