<?php
namespace src\Service\Writer;

use src\Collection\Collection;
use src\Domain\Criteria\FeatPreRequisCriteria;
use src\Domain\Entity\FeatPreRequis;
use src\Repository\FeatPreRequisRepositoryInterface;

final class FeatPreRequisWriter
{
    public function __construct(
        private FeatPreRequisRepositoryInterface $repository
    ) {}

    public function deleteFeatPreRequis(Collection $featPreRequis): void
    {
        foreach ($featPreRequis as $featPreRequi) {
            $this->repository->delete($featPreRequi);
        }
    }

    public function insert(FeatPreRequis $featPreRequis): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($featPreRequis);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function replaceFeatPreRequis(
        int $featId,
        array $preRequisIds
    ): void {
        $this->repository->beginTransaction();

        try {
            $criteria = new FeatPreRequisCriteria();
            $criteria->featId = $featId;

            $existing = $this->repository->findAllWithCriteria($criteria);

            $this->deleteFeatPreRequis($existing);

            foreach ($preRequisIds as $preRequisId) {
                $featPreRequis = new FeatPreRequis();
                $featPreRequis->featId = $featId;
                $featPreRequis->preRequisId = (int) $preRequisId;

                $this->repository->insert($featPreRequis);
            }

            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
