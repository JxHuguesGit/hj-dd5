<?php
namespace src\Service\Writer;

use src\Domain\Entity\InitiativeTracker;
use src\Repository\InitiativeTrackerRepositoryInterface;

final class InitiativeTrackerWriter
{
    public function __construct(
        private InitiativeTrackerRepositoryInterface $repository
    ) {}

    public function updatePartial(InitiativeTracker $initiativeTracker, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($initiativeTracker, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
