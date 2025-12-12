<?php
namespace src\Repository;

use src\Entity\Entity;
use src\Entity\RpgHerosSkill as EntityRpgHerosSkill;

class RpgHerosSkill extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHerosSkill::class;
    }
    
    public function deleteBy(array $criteria)
    {
        $objs = $this->findBy($criteria);
        foreach ($objs as $obj) {
            $this->delete($obj);
        }
    }
}
