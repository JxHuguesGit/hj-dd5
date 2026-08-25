<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MapFogCriteria;
use src\Domain\Entity\Map;
use src\Domain\Entity\MapFog;

class MapFogRepository extends Repository implements MapFogRepositoryInterface
{
    public const TABLE = Table::MAPFOG;
    
    public function getEntityClass(): string
    {
        return MapFog::class;
    }

    /**
     * @return ?MapFog
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?MapFog
    {
        return parent::find($id);
    }

    /**
     * @return Collection<MapFog>
     */
    public function findAllWithCriteria(MapFogCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

    public function discover(MapFog $mapFog): void
    {
        $this->query = $this->queryBuilder
            ->reset()
            ->getInsertOrIgnoreQuery(
                $this->fields,
                $this->table
            );

        $values = $this->getEntityValues($mapFog, true);

        $this->queryExecutor->insert(
            $this->query,
            $values
        );
    }

    public function deleteByMapId(int $mapId): void
    {
        $mapFogCriteria = new MapFogCriteria();
        $mapFogCriteria->mapId = $mapId;

        $this->deleteByCriteria($mapFogCriteria);
    }
}
