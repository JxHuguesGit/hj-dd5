<?php
namespace src\Repository;

use src\Constant\Field as F;
use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MapTokenCriteria;
use src\Domain\Entity\MapToken;
use src\Query\QueryBuilder;

class MapTokenRepository extends Repository implements MapTokenRepositoryInterface
{
    public const TABLE = Table::MAPTOKEN;
    
    public function getEntityClass(): string
    {
        return MapToken::class;
    }

    /**
     * @return ?MapToken
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?MapToken
    {
        return parent::find($id);
    }

    /**
     * @return Collection<MapToken>
     */
    public function findAllWithCriteria(MapTokenCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }


    /**
     * @return Collection<MapToken>
     */
    public function findAllWithRelations(MapTokenCriteria $criteria): Collection
    {
        $baseQuery = "
            SELECT mp.".F::ID." as ".F::ID.", ".F::MAPID.", ".F::TOKENID."
                , mp.".F::COLUMN.", ".F::ROW.", mp.".F::SIZE." as ".F::SIZE."
                , ".F::NUMBER.", ".F::NAME.", ".F::IMAGE."
            FROM " . Table::MAPTOKEN . " mp
            INNER JOIN " . Table::TOKEN . " t ON mp.".F::TOKENID." = t.".F::ID."
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
