<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MapTokenCriteria;
use src\Domain\Entity\MapToken;

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
}
