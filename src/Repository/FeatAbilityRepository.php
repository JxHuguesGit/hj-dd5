<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\FeatAbility;

class FeatAbilityRepository extends Repository implements FeatAbilityRepositoryInterface
{
    public const TABLE = Table::FEATABILITY;

    public function getEntityClass(): string
    {
        return FeatAbility::class;
    }

    /**
     * @return Collection<FeatAbility>
     */
    public function findAllWithCriteria(FeatAbilityCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
