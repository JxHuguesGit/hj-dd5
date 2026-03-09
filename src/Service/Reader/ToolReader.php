<?php
namespace src\Service\Reader;

use src\Constant\Field as F;
use src\Collection\Collection;
use src\Domain\Criteria\ToolCriteria;
use src\Domain\Entity\Tool;
use src\Repository\ToolRepositoryInterface;
use src\Utils\Navigation;

final class ToolReader
{
    public function __construct(
        private ToolRepositoryInterface $toolRepository
    ) {}

    /**
     * @return ?Tool
     */
    public function itemBySlug(string $slug): ?Tool
    {
        $criteria = new ToolCriteria();
        $criteria->slug = $slug;
        return $this->toolRepository->findAllWithRelations($criteria)?->first() ?? null;
    }

    /**
     * @return ?Tool
     */
    public function findWithRelations(int $id): ?Tool
    {
        return $this->toolRepository->findWithRelations($id);
    }

    /**
     * @return Collection<Tool>
     */
    public function allTools(): Collection
    {
        return $this->toolRepository->findAllWithRelations(new ToolCriteria());
    }

    public function getPreviousAndNext(Tool $tool): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($tool) {
                $criteria = new ToolCriteria();
                $criteria->parentId = $tool->parentId;
                $operand === '&lt;'
                    ? $criteria->nameLt = $tool->name
                    : $criteria->nameGt = $tool->name
                ;
                $criteria->orderBy = [F::NAME => $order];
                return $this->toolRepository->findAllWithRelations($criteria);
            }
        );
    }
}
