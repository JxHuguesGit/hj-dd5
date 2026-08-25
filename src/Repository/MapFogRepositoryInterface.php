<?php
namespace src\Repository;

use src\Domain\Entity\MapFog;
use src\Collection\Collection;
use src\Domain\Criteria\MapFogCriteria;

interface MapFogRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(MapFog $mapFog): void;
    public function delete(MapFog $mapFog): void;

    /**
     * @return ?MapFog
     */
    public function find(int $id): ?MapFog;

    /**
     * @return Collection<MapFog>
     */
    public function findAllWithCriteria(MapFogCriteria $criteria): Collection;

    public function discover(MapFog $mapFog): void;
    public function deleteByMapId(int $mapId): void;
}
