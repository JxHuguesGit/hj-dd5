<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\PreRequisCriteria;
use src\Domain\Entity\PreRequis;
use src\Repository\PreRequisRepositoryInterface;

final class PreRequisReader
{
    public function __construct(
        private PreRequisRepositoryInterface $preRequisRepository
    ) {}
     
    /**
     * @return ?PreRequis
     */
    public function preRequisById(int $id): ?PreRequis
    {
        return $this->preRequisRepository->find($id);
    }

    /**
     * @return Collection<PreRequis>
     */
    public function allPreRequis(): Collection
    {
        return $this->preRequisRepository->findAllWithCriteria(new PreRequisCriteria());
    }
}
