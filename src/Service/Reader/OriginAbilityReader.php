<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\OriginAbilityCriteria;
use src\Domain\Entity\OriginAbility;
use src\Repository\OriginAbilityRepositoryInterface;

final class OriginAbilityReader
{
    public function __construct(
        private OriginAbilityRepositoryInterface $repository
    ) {}

    /**
     * @return ?OriginAbility
     */
    public function originAbilityById(int $id): ?OriginAbility
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<OriginAbility>
     */
    public function originAbilitysByAbility(int $abilityId): Collection
    {
        $criteria            = new OriginAbilityCriteria();
        $criteria->abilityId = $abilityId;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<OriginAbility>
     */
    public function originAbilitysByOrigin(int $originId): Collection
    {
        $criteria           = new OriginAbilityCriteria();
        $criteria->originId = $originId;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
