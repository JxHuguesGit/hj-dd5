<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\AbilityCriteria;
use src\Domain\Entity\Ability;
use src\Repository\AbilityRepositoryInterface;

final class AbilityReader
{
    public function __construct(
        private AbilityRepositoryInterface $repository
    ) {}

    /**
     * @return ?Ability
     */
    public function abilityById(int $id): ?Ability
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<Ability>
     */
    public function allAbilities(?AbilityCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new AbilityCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
