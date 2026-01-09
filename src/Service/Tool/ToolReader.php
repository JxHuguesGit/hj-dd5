<?php
namespace src\Service\Tool;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Tool as DomainTool;
use src\Repository\Tool as RepositoryTool;

final class ToolReader
{
    public function __construct(
        private RepositoryTool $toolRepository
    ) {}
    
    public function getAllTools(): Collection
    {
        $orderBy = [
            Field::PARENTID=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->toolRepository->findByCategory($orderBy);
    }

    public function getTool(int $id): ?DomainTool
    {
        return $this->toolRepository->find($id);
    }
}
