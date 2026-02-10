<?php
namespace src\Repository;

use src\Domain\Tool as DomainTool;
use src\Collection\Collection;
use src\Domain\Criteria\ToolCriteria;

interface ToolRepositoryInterface
{
    /**
     * @return ?DomainTool
     */
    public function find(int $id): ?DomainTool;

    /**
     * @return Collection<DomainTool>
     */
    public function findAllWithItemAndType(ToolCriteria $criteria): Collection;
}
