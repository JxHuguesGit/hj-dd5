<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpeciePowerCriteria;
use src\Domain\Entity\SpeciePower;

class SpeciePowerRepository extends Repository implements SpeciePowerRepositoryInterface
{
    public const TABLE = Table::SPECIEPOWER;

    public function getEntityClass(): string
    {
        return SpeciePower::class;
    }

    /**
     * @return Collection<SpeciePower>
     */
    public function findAllWithCriteria(SpeciePowerCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
