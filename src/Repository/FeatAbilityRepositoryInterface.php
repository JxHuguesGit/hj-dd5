<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\FeatAbility;

interface FeatAbilityRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(FeatAbility $featAbility): void;
    public function delete(FeatAbility $featAbility): void;

    /**
     * @return Collection<FeatAbility>
     */
    public function findAllWithCriteria(FeatAbilityCriteria $criteria): Collection;
}
