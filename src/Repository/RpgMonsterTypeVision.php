<?php
namespace src\Repository;

use src\Entity\RpgMonsterTypeVision as EntityRpgMonsterTypeVision;

class RpgMonsterTypeVision extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterTypeVision::class;
    }
}
