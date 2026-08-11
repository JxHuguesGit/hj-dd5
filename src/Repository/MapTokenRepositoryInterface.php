<?php
namespace src\Repository;

use src\Domain\Entity\MapToken;
use src\Collection\Collection;
use src\Domain\Criteria\MapTokenCriteria;

interface MapTokenRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function updatePartial(MapToken $mapToken, array $changedFields): void;
    public function insert(MapToken $mapToken): void;
    public function delete(MapToken $mapToken): void;

    /**
     * @return ?MapToken
     */
    public function find(int $id): ?MapToken;

    /**
     * @return Collection<MapToken>
     */
    public function findAllWithCriteria(MapTokenCriteria $criteria): Collection;

    /**
     * @return Collection<MapToken>
     */
    public function findAllWithRelations(MapTokenCriteria $criteria): Collection;
}
