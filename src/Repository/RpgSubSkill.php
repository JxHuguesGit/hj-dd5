<?php
namespace src\Repository;

use src\Entity\RpgSubSkill as EntityRpgSubSkill;

class RpgSubSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgSubSkill::class;
    }
}
