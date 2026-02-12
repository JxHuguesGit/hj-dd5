<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterCriteria;

interface MonsterRepositoryInterface
{
   public function findAllWithJoint(MonsterCriteria $criteria): Collection;
}
