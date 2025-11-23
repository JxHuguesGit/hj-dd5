<?php
namespace src\Repository;

use src\Entity\RpgHerosSkill as EntityRpgHerosSkill;

class RpgHerosSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHerosSkill::class;
    }
}
