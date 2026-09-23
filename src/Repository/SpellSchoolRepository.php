<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SpellSchoolCriteria;
use src\Domain\Entity\SpellSchool;

class SpellSchoolRepository extends Repository implements SpellSchoolRepositoryInterface
{
    public const TABLE = Table::SPELLSCHOOL;

    public function getEntityClass(): string
    {
        return SpellSchool::class;
    }

    /**
     * @return ?SpellSchool
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SpellSchool
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SpellSchool>
     */
    public function findAllWithCriteria(SpellSchoolCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
