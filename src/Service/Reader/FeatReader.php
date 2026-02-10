<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Entity\Feat;
use src\Repository\FeatRepositoryInterface;
use src\Utils\Navigation;

final class FeatReader
{
    public function __construct(
        private FeatRepositoryInterface $featRepository,
    ) {}

    /**
     * @return ?Feat
     */
    public function featById(int $id): ?Feat
    {
        return $this->featRepository->find($id);
    }

    /**
     * @return ?Feat
     */
    public function featBySlug(string $slug): ?Feat
    {
        $criteria = new FeatCriteria();
        $criteria->slug = $slug;
        return $this->featRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Feat>
     */
    public function allFeats(array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $criteria = new FeatCriteria();
        $criteria->orderBy = $order;
        return $this->featRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<Feat>
     */
    public function featsByCategory(int $categoryId, array $order=[Field::NAME=>Constant::CST_ASC]): Collection
    {
        $criteria = new FeatCriteria();
        $criteria->featTypeId = $categoryId;
        $criteria->orderBy    = $order;
        return $this->featRepository->findAllWithCriteria($criteria);
    }

    public function getPreviousAndNext(Feat $feat): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($feat) {
                $criteria = new FeatCriteria();
                $criteria->featTypeId = $feat->featTypeId;
                $operand === '&lt;'
                    ? $criteria->nameLt = $feat->name
                    : $criteria->nameGt = $feat->name
                ;
                $criteria->orderBy = [Field::NAME => $order];
                return $this->featRepository->findAllWithCriteria($criteria);
            }
        );
    }
}
