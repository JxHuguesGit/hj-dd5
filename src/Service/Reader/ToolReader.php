<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\ToolCriteria;
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
        return $this->toolRepository->findAllWithItemAndType(new ToolCriteria());
    }
}
