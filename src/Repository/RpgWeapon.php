<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\RpgWeapon as DomainRpgWeapon;

class RpgWeapon extends Repository
{
    public const TABLE = Table::WEAPON;

    public function getEntityClass(): string
    {
        return DomainRpgWeapon::class;
    }

    /**
     * Retourne toutes les armes avec les infos issues de item et weapon
     */
    public function findAllWithItemAndType(array $criteria=[], array $orderBy=['i.name'=>Constant::CST_ASC]): Collection
    {
        $baseQuery = "
            SELECT a.id
                , i.".Field::NAME." AS ".Field::NAME.", ".Field::WEIGHT.", ".Field::GOLDPRICE."
                , c.".Field::SLUG." AS ".Field::CATEGORYSLUG.", c.".Field::NAME." AS ".Field::CATEGORYNAME."
                , p.".Field::NAME." AS ".Field::MASTERYNAME."
                , ".Field::DICECOUNT.", ".Field::DICEFACES."
                , td.".Field::NAME." AS ".Field::TYPDMGNAME."
                , r.".Field::SLUG." AS ".Field::RANGESLUG.", r.".Field::NAME." AS ".Field::RANGENAME."
            FROM " . Table::WEAPON . " a
            INNER JOIN " . Table::ITEM . " i ON i.id = a.id
            INNER JOIN " . Table::WPNCATEGORY . " c ON c.id = a.".Field::WPNCATID."
            INNER JOIN " . Table::MSTPROFCY . " p ON p.id = a.".Field::MSTPROFID."
            INNER JOIN " . Table::DMGDIE . " d ON d.id = a.".Field::DMGDIEID."
            INNER JOIN " . Table::TYPEDAMAGE . " td ON td.id = a.".Field::TYPEDMGID."
            INNER JOIN " . Table::WPNRANGE . " r ON r.id = a.".Field::WPNRANGEID."
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
     * Filtre les armes par catégorie (ex: 'armor')
     */
    public function findByCategory(string $slug, array $orderBy=[]): Collection
    {
        return $this->findAllWithItemAndType([Field::TYPE=>$slug], $orderBy);
    }
}
