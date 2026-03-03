<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\Feat;
use src\Domain\Entity\FeatAbility;
use src\Repository\FeatAbilityRepositoryInterface;

final class FeatAbilityReader
{
    public function __construct(
        private FeatAbilityRepositoryInterface $featAbilityRepository
    ) {}

    /**
     * @return Collection<FeatAbility>
     */
    public function featAbilitiesByFeatId(int $featId): Collection
    {
        $criteria         = new FeatAbilityCriteria();
        $criteria->featId = $featId;
        return $this->featAbilityRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<FeatAbility>
     */
    public function allFeatAbilities(?FeatAbilityCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new FeatAbilityCriteria();
        }
        return $this->featAbilityRepository->findAllWithCriteria($criteria);
    }
}
