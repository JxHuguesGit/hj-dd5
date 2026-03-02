<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\OriginAbilityCriteria;
use src\Domain\Entity\OriginAbility;

class OriginAbilityRepository extends Repository implements OriginAbilityRepositoryInterface
{
    public const TABLE = Table::ORIGINABILITY;

    public function getEntityClass(): string
    {
        return OriginAbility::class;
    }

    /**
     * @return Collection<OriginAbility>
     */
    public function findAllWithCriteria(OriginAbilityCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
