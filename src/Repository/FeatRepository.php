<?php
namespace src\Repository;

use src\Constant\Field as F;
use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Entity\Feat;
use src\Query\QueryBuilder;

class FeatRepository extends Repository implements FeatRepositoryInterface
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return Feat::class;
    }

    /**
     * @return ?Feat
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Feat
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Feat>
     */
    public function findAllWithCriteria(FeatCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

    /**
     * @return Collection<Feat>
     */
    public function findAllWithRelations(FeatCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT f." . F::ID . ", f." . F::FEATTYPEID . ", f." . F::WPPOSTID . ",
                f." . F::SOURCEID . ", f." . F::PREREQUISID . ",
                wp.post_title AS " . F::NAME . ", wp.post_name AS " . F::SLUG . "
            FROM " . Table::FEAT . " f
            LEFT JOIN " . Table::WPPOST . " wp
                ON f." . F::WPPOSTID . " = wp.ID
        ";

        $queryBuilder = new QueryBuilder();
        $queryBuilder->setBaseQuery($baseQuery);
        $criteria->apply($queryBuilder);

        $this->query = $queryBuilder->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $queryBuilder->getParams()
        );
    }
}
