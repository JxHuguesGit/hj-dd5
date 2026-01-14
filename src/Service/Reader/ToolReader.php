<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Tool as DomainTool;
use src\Repository\ToolRepositoryInterface;

final class ToolReader
{
    public function __construct(
        private ToolRepositoryInterface $toolRepository
    ) {}
    
    /**
     * @return Collection<DomainTool>
     */
    public function allTools(): Collection
    {
        $orderBy = [
            Field::PARENTID=>Constant::CST_ASC,
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->toolRepository->findByCategory($orderBy);
    }

    public function toolById(int $id): ?DomainTool
    {
        return $this->toolRepository->find($id);
    }
}
