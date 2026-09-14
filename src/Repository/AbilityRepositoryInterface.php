<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\AbilityCriteria;
use src\Domain\Entity\Ability;

interface AbilityRepositoryInterface
{
    /**
     * @return ?Ability
     */
    public function find(int $id): ?Ability;

    /**
     * @return Collection<Ability>
     */
    public function findAllWithCriteria(AbilityCriteria $criteria): Collection;
}
