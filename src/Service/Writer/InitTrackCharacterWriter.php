<?php
namespace src\Service\Writer;

use src\Domain\Entity\ITCharacter;
use src\Repository\InitTrackCharacterRepositoryInterface;

final class InitTrackCharacterWriter
{
    public function __construct(
        private InitTrackCharacterRepositoryInterface $repository
    ) {}

    public function insert(ITCharacter $itCharacter): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($itCharacter);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(ITCharacter $itCharacter): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($itCharacter);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}