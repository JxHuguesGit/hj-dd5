<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\FeatTypeCriteria;
use src\Domain\Entity\FeatType;
use src\Repository\FeatTypeRepositoryInterface;

final class FeatTypeReader
{
    public function __construct(
        private FeatTypeRepositoryInterface $featTypeRepository
    ) {}
     
    /**
     * @return ?FeatType
     */
    public function featTypeById(int $id): ?FeatType
    {
        return $this->featTypeRepository->find($id);
    }
     
    public function featTypeBySlug(string $slug): ?FeatType
    {
        $criteria = new FeatTypeCriteria();
        $criteria->slug = $slug;

        return $this->featTypeRepository
            ->findAllWithCriteria($criteria)
            ?->first() ?? null;
    }

    /**
     * @return Collection<FeatType>
     */
    public function allFeatTypes(): Collection
    {
        return $this->featTypeRepository->findAllWithCriteria(new FeatTypeCriteria());
    }
}
