<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\FeatAbility;

interface FeatAbilityRepositoryInterface
{
    /**
     * @return Collection<FeatAbility>
     */
    public function findAllWithCriteria(FeatAbilityCriteria $criteria): Collection;
}
