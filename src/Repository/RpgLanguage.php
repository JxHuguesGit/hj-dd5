<?php
namespace src\Repository;

use src\Entity\RpgLanguage as EntityRpgLanguage;

class RpgLanguage extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgLanguage::class;
    }
}
