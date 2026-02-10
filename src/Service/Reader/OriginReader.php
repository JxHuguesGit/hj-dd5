<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\OriginCriteria;
use src\Domain\Entity\Feat;
use src\Domain\Entity\Origin;
use src\Domain\Entity\Tool;
use src\Repository\OriginRepositoryInterface;
use src\Utils\Navigation;

final class OriginReader
{
    public function __construct(
        private OriginRepositoryInterface $originRepository,
    ) {}

    /**
     * @return ?Origin
     */
    public function originById(int $id): ?Origin
    {
        return $this->originRepository->find($id);
    }

    /**
     * @return ?Origin
     */
    public function originBySlug(string $slug): ?Origin
    {
        $criteria = new OriginCriteria();
        $criteria->slug = $slug;
        return $this->originRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Origin>
     */
    public function allOrigins(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $criteria = new OriginCriteria();
        $criteria->orderBy = $order;
        return $this->originRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Origin>
     */
    public function originsByFeat(Feat $feat): Collection
    {
        $criteria = new OriginCriteria();
        $criteria->featId = $feat->id;
        return $this->originRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function originsByTool(Tool $tool): Collection
    {
        $criteria = new OriginCriteria();
        $criteria->toolId = $tool->id;
        return $this->originRepository->findAllWithCriteria($criteria);
    }

    public function getPreviousAndNext(Origin $origin): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($origin) {
                $criteria = new OriginCriteria();
                $operand === '&lt;'
                    ? $criteria->nameLt = $origin->name
                    : $criteria->nameGt = $origin->name
                ;
                $criteria->orderBy = [Field::NAME => $order];
                return $this->originRepository->findAllWithCriteria($criteria);
            }
        );
    }
}
