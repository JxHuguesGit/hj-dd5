<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Entity\Weapon;
use src\Domain\Criteria\WeaponCriteria;
use src\Query\QueryBuilder;

class WeaponRepository extends Repository implements WeaponRepositoryInterface
{
    public const INNERJOIN = 'INNER JOIN ';
    public const TABLE = Table::WEAPON;

    public function getEntityClass(): string
    {
        return Weapon::class;
    }

    /**
     * @return Weapon
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): Weapon
    {
        return parent::find($id);
    }

    /**
     * @return ?Weapon
     */
    public function findWithRelations(int $id): ?Weapon
    {
        $criteria = new WeaponCriteria();
        $criteria->id = $id;
        return $this->findAllWithRelations($criteria)->first() ?? null;
    }

    /**
     * @return Collection<Weapon>
     */
    public function findAllWithRelations(WeaponCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT a.id
                , i.".Field::NAME." AS ".Field::NAME.", i.".Field::SLUG." AS ".Field::SLUG."
                , ".Field::WEIGHT.", ".Field::GOLDPRICE.", ".Field::TYPE."
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

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder
            ->orderBy($criteria->orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }
}
