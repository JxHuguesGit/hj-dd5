<?php
namespace src\Service\Writer;

use src\Constant\Field as F;
use src\Domain\Entity\Map;
use src\Repository\MapRepositoryInterface;

final class MapWriter
{
    public function __construct(
        private MapRepositoryInterface $repository
    ) {}

    public function updatePartial(Map $map, array $changedFields): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->updatePartial($map, $changedFields);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function insertWithoutTransaction(Map $map): void
    {
        $this->repository->insert($map);
    }

    public function deleteWithoutTransaction(Map $map): void
    {
        $this->repository->delete($map);
    }

    public function activate(Map $map, ?Map $activeMap): void
    {
        $this->repository->beginTransaction();

        try {
            if ($activeMap !== null && $activeMap->id !== $map->id) {
                $activeMap->active = 0;

                $this->repository->updatePartial(
                    $activeMap,
                    [F::ACTIVE]
                );
            }

            $map->active = 1;

            $this->repository->updatePartial(
                $map,
                [F::ACTIVE]
            );

            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function beginTransaction(): void
    {
        $this->repository->beginTransaction();
    }

    public function commit(): void
    {
        $this->repository->commit();
    }

    public function rollBack(): void
    {
        $this->repository->rollBack();
    }
}
