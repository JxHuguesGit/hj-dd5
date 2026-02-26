<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\DamageTypeCriteria;
use src\Domain\Entity\DamageType;

class DamageTypeRepository extends Repository implements DamageTypeRepositoryInterface
{
    public const TABLE = Table::DAMAGETYPE;

    public function getEntityClass(): string
    {
        return DamageType::class;
    }

    /**
     * @return ?DamageType
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?DamageType
    {
        return parent::find($id);
    }

    /**
     * @return Collection<DamageType>
     */
    public function findAllWithCriteria(DamageTypeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
