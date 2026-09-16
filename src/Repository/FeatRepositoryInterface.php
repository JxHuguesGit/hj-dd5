<?php
namespace src\Repository;

use src\Domain\Entity\Feat;
use src\Collection\Collection;
use src\Domain\Criteria\FeatCriteria;

interface FeatRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(Feat $feat): void;
    public function updatePartial(Feat $feat, array $changedFields): void;

    /**
     * @return ?Feat
     */
    public function find(int $id): ?Feat;

    /**
     * @return Collection<Feat>
     */
    public function findAllWithCriteria(FeatCriteria $criteria): Collection;

    /**
     * @return Collection<Feat>
     */
    public function findAllWithRelations(FeatCriteria $criteria): Collection;
}
