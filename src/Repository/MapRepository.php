<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MapCriteria;
use src\Domain\Entity\Map;

class MapRepository extends Repository implements MapRepositoryInterface
{
    public const TABLE = Table::MAP;
    
    public function getEntityClass(): string
    {
        return Map::class;
    }

    /**
     * @return ?Map
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Map
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Map>
     */
    public function findAllWithCriteria(MapCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
