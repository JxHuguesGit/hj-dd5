<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field as F;
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
                , i.".F::NAME." AS ".F::NAME.", i.".F::SLUG." AS ".F::SLUG."
                , ".F::WEIGHT.", ".F::GOLDPRICE.", ".F::TYPE."
                , c.".F::SLUG." AS ".F::CATEGORYSLUG.", c.".F::NAME." AS ".F::CATEGORYNAME."
                , p.".F::NAME." AS ".F::MASTERYNAME.", p.".F::POSTID." AS ".F::MASTERYPOSTID."
                , ".F::DICECOUNT.", ".F::DICEFACES."
                , td.".F::NAME." AS ".F::TYPDMGNAME."
                , r.".F::SLUG." AS ".F::RANGESLUG.", r.".F::NAME." AS ".F::RANGENAME."
            FROM " . Table::WEAPON . " a ".
            self::INNERJOIN . Table::ITEM . " i ON i.id = a.id " .
            self::INNERJOIN . Table::WPNCATEGORY . " c ON c.id = a.".F::WPNCATID." " .
            self::INNERJOIN . Table::MSTPROFCY . " p ON p.id = a.".F::MSTPROFID." " .
            self::INNERJOIN . Table::DMGDIE . " d ON d.id = a.".F::DMGDIEID." " .
            self::INNERJOIN . Table::DAMAGETYPE . " td ON td.id = a.".F::TYPEDMGID." " .
            self::INNERJOIN . Table::WPNRANGE . " r ON r.id = a.".F::WPNRANGEID."
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
