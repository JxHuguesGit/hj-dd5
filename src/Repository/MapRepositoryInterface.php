<?php
namespace src\Repository;

use src\Domain\Entity\Map;
use src\Collection\Collection;
use src\Domain\Criteria\MapCriteria;

interface MapRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function updatePartial(Map $map, array $changedFields): void;

    /**
     * @return ?Map
     */
    public function find(int $id): ?Map;

    /**
     * @return Collection<Map>
     */
    public function findAllWithCriteria(MapCriteria $criteria): Collection;
}
