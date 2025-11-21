<?php
namespace src\Repository;

use src\Entity\RpgMonsterTypeSpeed as EntityRpgMonsterTypeSpeed;

class RpgMonsterTypeSpeed extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterTypeSpeed::class;
    }
}
