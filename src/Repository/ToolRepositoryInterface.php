<?php
namespace src\Repository;

use src\Domain\Tool as DomainTool;
use src\Collection\Collection;

interface ToolRepositoryInterface
{
    public function find(int $id): ?DomainTool;
    /**
     * @return Collection<DomainTool>
     */
    public function findAll(): Collection;
    /**
     * @return Collection<DomainTool>
     */
    public function findByCategory(array $orderBy = []): Collection;
}
