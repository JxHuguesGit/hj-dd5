<?php
namespace src\Repository;

use src\Entity\RpgTypeSpeed as EntityRpgTypeSpeed;

class RpgTypeSpeed extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTypeSpeed::class;
    }
}
