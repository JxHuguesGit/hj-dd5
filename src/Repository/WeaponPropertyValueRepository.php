<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Criteria\WeaponPropertyValueCriteria;
use src\Domain\Entity\WeaponPropertyValue;
use src\Query\QueryBuilder;

class WeaponPropertyValueRepository extends Repository implements WeaponPropertyValueRepositoryInterface
{
    public const TABLE = Table::WPNPROPVALUE;

    public function getEntityClass(): string
    {
        return WeaponPropertyValue::class;
    }

    /**
     * @return ?WeaponPropertyValue
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?WeaponPropertyValue
    {
        return parent::find($id);
    }

    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function findAllWithRelations(WeaponPropertyValueCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT " . Field::MINRANGE . ", " . Field::MAXRANGE . "
                , wp." . Field::NAME . " AS " . Field::PROPERTYNAME . ", wp." . Field::SLUG . " AS " . Field::PROPERTYSLUG . "
                , " . Field::POSTID . "
                , ta." . Field::NAME . " AS " . Field::AMMONAME . "
                , " . Field::DICECOUNT . ", " . Field::DICEFACES . "
            FROM " . Table::WPNPROPVALUE . " wpv
            INNER JOIN " . Table::WPNPROPERTY . " wp ON wp.id = wpv." . Field::WPNPROPID . "
            LEFT JOIN " . Table::TYPEAMMO . " ta ON ta.id = wpv." . Field::TYPEAMMID . "
            LEFT JOIN " . Table::DMGDIE . " dd ON dd.id = wpv." . Field::DMGDIEID . "
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
