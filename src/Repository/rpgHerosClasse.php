<?php
namespace src\Repository;

use src\Entity\Entity;
use src\Entity\RpgHerosClasse as EntityRpgHerosClasse;

class RpgHerosClasse extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHerosClasse::class;
    }
    
    public function deleteBy(array $criteria)
    {
        $objs = $this->findBy($criteria);
        foreach ($objs as $obj) {
            $this->delete($obj);
        }
    }
}
