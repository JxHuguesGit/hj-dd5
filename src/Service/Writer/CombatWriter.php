<?php

namespace src\Service\Writer;

use src\Domain\Entity\Combat;
use src\Repository\CombatRepositoryInterface;

final class CombatWriter
{
    public function __construct(
        private CombatRepositoryInterface $repository
    ) {}

    public function insert(Combat $combat): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($combat);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(Combat $combat, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($combat, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(Combat $combat): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($combat);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
