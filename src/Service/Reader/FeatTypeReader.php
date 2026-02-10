<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\FeatTypeCriteria;
use src\Domain\FeatType as DomainFeatType;
use src\Repository\FeatTypeRepositoryInterface;

final class FeatTypeReader
{
    public function __construct(
        private FeatTypeRepositoryInterface $featTypeRepository
    ) {}
     
    /**
     * @return Collection<DomainFeatType>
     */
    public function allFeatTypes(): Collection
    {
        return $this->featTypeRepository->findAllWithCriteria(new FeatTypeCriteria());
    }
}
