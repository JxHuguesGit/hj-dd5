<?php
namespace src\Service\Writer;

use src\Domain\Entity\Feat;
use src\Repository\FeatRepositoryInterface;

class FeatWriter
{
    public function __construct(
        private FeatRepositoryInterface $repository
    ) {}

    public function insert(Feat $feat): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($feat);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Feat $feat, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($feat, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
