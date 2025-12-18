<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\RpgArmor as DomainRpgArmor;

class RpgArmor extends Repository
{
    public const TABLE = Table::ARMOR;

    public function getEntityClass(): string
    {
        return DomainRpgArmor::class;
    }

    /**
     * Retourne toutes les armures avec les infos issues de item et armor_type
     */
    public function findAllWithItemAndType(array $criteria=[], array $orderBy=['i.name'=>Constant::CST_ASC]): Collection
    {
        $baseQuery = "
            SELECT a.id, a.".Field::ARMORTYPID.", a.".Field::ARMORCLASS.", a.".Field::STRPENALTY.", a.".Field::STHDISADV."
                , i.".Field::NAME.", i.".Field::WEIGHT.", i.".Field::GOLDPRICE."
            FROM " . Table::ARMOR . " a
            INNER JOIN " . Table::ITEM . " i ON i.id = a.id
        ";

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
            ->where($criteria)
            ->orderBy($orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }

    /**
     * Filtre les armures par catégorie (ex: 'armor')
     */
    public function findByCategory(string $slug, array $orderBy=[]): Collection
    {
        return $this->findAllWithItemAndType([Field::TYPE=>$slug], $orderBy);
    }
}
