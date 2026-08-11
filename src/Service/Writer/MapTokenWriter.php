<?php
namespace src\Service\Writer;

use src\Domain\Entity\MapToken;
use src\Repository\MapTokenRepositoryInterface;

final class MapTokenWriter
{
    public function __construct(
        private MapTokenRepositoryInterface $repository
    ) {}

    public function updatePartial(MapToken $token, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($token, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function insert(MapToken $mapToken): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($mapToken);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(MapToken $mapToken): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($mapToken);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }
}
