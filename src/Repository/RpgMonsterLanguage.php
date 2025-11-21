<?php
namespace src\Repository;

use src\Entity\RpgMonsterLanguage as EntityRpgMonsterLanguage;

class RpgMonsterLanguage extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterLanguage::class;
    }
}
