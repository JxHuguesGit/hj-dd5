<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\OriginCriteria;
use src\Domain\Feat as DomainFeat;
use src\Domain\Origin as DomainOrigin;
use src\Domain\Tool as DomainTool;
use src\Repository\OriginRepositoryInterface;
use src\Utils\Navigation;

final class OriginReader
{
    public function __construct(
        private OriginRepositoryInterface $originRepository,
    ) {}

    public function originById(int $id): ?DomainOrigin
    {
        return $this->originRepository->find($id);
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function allOrigins(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        return $this->originRepository->findAll($order);
    }

    public function originBySlug(string $slug): ?DomainOrigin
    {
        $criteria = new OriginCriteria();
        $criteria->slug = $slug;
        return $this->originRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function originsByFeat(DomainFeat $feat): Collection
    {
        $criteria = new OriginCriteria();
        $criteria->featId = $feat->id;
        return $this->originRepository->findAllWithCriteria($criteria);
    }

    public function originsByTool(DomainTool $tool): Collection
    {
        $criteria = new OriginCriteria();
        $criteria->toolId = $tool->id;
        return $this->originRepository->findAllWithCriteria($criteria);
    }

    public function getPreviousAndNext(DomainOrigin $origin): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($origin) {
                $criteria = new OriginCriteria();
                $operand === '<'
                    ? $criteria->nameLt = $origin->name
                    : $criteria->nameGt = $origin->name
                ;
                return $this->originRepository->findAllWithCriteria($criteria, [Field::NAME => $order]);
            }
        );
    }
}
