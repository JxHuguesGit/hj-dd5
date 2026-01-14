<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Weapon as DomainWeapon;

class Weapon extends Repository
{
    public const INNERJOIN = 'INNER JOIN ';
    public const TABLE = Table::WEAPON;

    public function getEntityClass(): string
    {
        return DomainWeapon::class;
    }

    /**
     * Retourne toutes les armes avec les infos issues de item et weapon
     */
    public function findAllWithItemAndType(array $criteria=[], array $orderBy=['i.name'=>Constant::CST_ASC]): Collection
    {
        $baseQuery = "
            SELECT a.id
                , i.".Field::NAME." AS ".Field::NAME.", i.".Field::SLUG." AS ".Field::SLUG."
                , ".Field::WEIGHT.", ".Field::GOLDPRICE."
                , c.".Field::SLUG." AS ".Field::CATEGORYSLUG.", c.".Field::NAME." AS ".Field::CATEGORYNAME."
                , p.".Field::NAME." AS ".Field::MASTERYNAME.", p.".Field::POSTID." AS ".Field::MASTERYPOSTID."
                , ".Field::DICECOUNT.", ".Field::DICEFACES."
                , td.".Field::NAME." AS ".Field::TYPDMGNAME."
                , r.".Field::SLUG." AS ".Field::RANGESLUG.", r.".Field::NAME." AS ".Field::RANGENAME."
            FROM " . Table::WEAPON . " a ".
            self::INNERJOIN . Table::ITEM . " i ON i.id = a.id " .
            self::INNERJOIN . Table::WPNCATEGORY . " c ON c.id = a.".Field::WPNCATID." " .
            self::INNERJOIN . Table::MSTPROFCY . " p ON p.id = a.".Field::MSTPROFID." " .
            self::INNERJOIN . Table::DMGDIE . " d ON d.id = a.".Field::DMGDIEID." " .
            self::INNERJOIN . Table::TYPEDAMAGE . " td ON td.id = a.".Field::TYPEDMGID." " .
            self::INNERJOIN . Table::WPNRANGE . " r ON r.id = a.".Field::WPNRANGEID."
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

    public function findByCategory(array $orderBy=[]): Collection
    {
        return $this->findAllWithItemAndType([Field::TYPE=>Constant::CST_WEAPON], $orderBy);
    }
}
