<?php

namespace src\Service\Writer;

use src\Domain\Entity\CombatParticipant;
use src\Repository\CombatParticipantRepositoryInterface;

final class CombatParticipantWriter
{
    public function __construct(
        private CombatParticipantRepositoryInterface $repository
    ) {}

    public function insert(CombatParticipant $participant): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($participant);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function updatePartial(
        CombatParticipant $participant,
        array $changedFields
    ): void {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($participant, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(CombatParticipant $participant): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($participant);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
