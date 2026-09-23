<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\SpellSchoolCriteria;
use src\Domain\Entity\SpellSchool;

interface SpellSchoolRepositoryInterface
{
    /**
     * @return ?SpellSchool
     */
    public function find(int $id): ?SpellSchool;

    /**
     * @return Collection<SpellSchool>
     */
    public function findAllWithCriteria(SpellSchoolCriteria $criteria): Collection;
}
