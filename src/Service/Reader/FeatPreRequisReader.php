<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\FeatPreRequisCriteria;
use src\Domain\Entity\FeatPreRequis;
use src\Repository\FeatPreRequisRepositoryInterface;

final class FeatPreRequisReader
{
    public function __construct(
        private FeatPreRequisRepositoryInterface $featPreRequisRepository
    ) {}

    /**
     * @return Collection<FeatPreRequis>
     */
    public function featPreRequisByFeatId(?int $featId): Collection
    {
        $criteria         = new FeatPreRequisCriteria();
        $criteria->featId = $featId;
        return $this->featPreRequisRepository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<FeatPreRequis>
     */
    public function allFeatPreRequis(?FeatPreRequisCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new FeatPreRequisCriteria();
        }
        return $this->featPreRequisRepository->findAllWithCriteria($criteria);
    }
}
