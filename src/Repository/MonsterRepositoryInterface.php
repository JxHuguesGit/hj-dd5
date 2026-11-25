<?php

namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Monster\Monster;

interface MonsterRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function updatePartial(Monster $monster, array $changedFields): void;

    /**
     * @return ?Monster
     */
    public function find(int $id): ?Monster;

    public function findAllWithRelations(MonsterCriteria $criteria): Collection;
}
