<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\TypeMonstre;

class TypeMonstreRepository extends Repository
{
    public const TABLE = Table::TYPEMONSTRE;

    public function getEntityClass(): string
    {
        return TypeMonstre::class;
    }

    /**
     * @return TypeMonstre
     */
    public function find(int $id): TypeMonstre
    {
        return parent::find($id) ?? new TypeMonstre();
    }
}
