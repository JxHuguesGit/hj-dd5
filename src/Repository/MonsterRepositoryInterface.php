<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Monster\Monster;

interface MonsterRepositoryInterface
{
   /**
    * @return ?Monster
    */
   public function find(int $id): ?Monster;

   public function findAllWithRelations(MonsterCriteria $criteria): Collection;
}
