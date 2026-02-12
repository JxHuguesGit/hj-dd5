<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\TypeMonsterCriteria;
use src\Domain\Entity\TypeMonster;

class TypeMonsterRepository extends Repository implements TypeMonsterRepositoryInterface
{
    public const TABLE = Table::TYPEMONSTRE;

    public function getEntityClass(): string
    {
        return TypeMonster::class;
    }

    /**
     * @return TypeMonster
     */
    public function find(int $id): TypeMonster
    {
        return parent::find($id) ?? new TypeMonster();
    }

    /**
     * @return Collection<TypeMonster>
     */
    public function findAllWithCriteria(
        TypeMonsterCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
