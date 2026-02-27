<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterAbilityCriteria;
use src\Domain\Entity\MonsterAbility;
use src\Repository\MonsterAbilityRepositoryInterface;

final class MonsterAbilityReader
{
    public function __construct(
        private MonsterAbilityRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterAbility
     */
    public function monsterAbilityById(int $id): ?MonsterAbility
    {
        return $this->repository->find($id);
    }

    public function monsterAbilitiesByMonsterId(int $id): Collection
    {
        $criteria            = new MonsterAbilityCriteria();
        $criteria->monsterId = $id;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterAbility>
     */
    public function allMonsterAbilities(?MonsterAbilityCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterAbilityCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
