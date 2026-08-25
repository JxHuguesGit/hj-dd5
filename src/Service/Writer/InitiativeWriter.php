<?php
namespace src\Service\Writer;

use src\Domain\Entity\Initiative;
use src\Repository\InitiativeRepositoryInterface;

final class InitiativeWriter
{
    public function __construct(
        private InitiativeRepositoryInterface $repository
    ) {}

    public function insert(Initiative $initiative): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($initiative);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Initiative $initiative, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($initiative, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(Initiative $initiative): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($initiative);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
