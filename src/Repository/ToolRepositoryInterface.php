<?php
namespace src\Repository;

use src\Domain\Tool as DomainTool;
use src\Collection\Collection;

interface ToolRepositoryInterface
{
    public function find(int $id): ?DomainTool;
    public function findAll(): Collection;
}
