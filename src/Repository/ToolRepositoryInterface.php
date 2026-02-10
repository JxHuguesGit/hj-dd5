<?php
namespace src\Repository;

use src\Domain\Entity\Tool;
use src\Collection\Collection;
use src\Domain\Criteria\ToolCriteria;

interface ToolRepositoryInterface
{
    /**
     * @return ?Tool
     */
    public function find(int $id): ?Tool;

    /**
     * @return Collection<Tool>
     */
    public function findAllWithItemAndType(ToolCriteria $criteria): Collection;
}
