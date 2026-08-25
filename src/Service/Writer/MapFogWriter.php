<?php
namespace src\Service\Writer;

use src\Domain\Entity\MapFog;
use src\Repository\MapFogRepositoryInterface;

final class MapFogWriter
{
    public function __construct(
        private MapFogRepositoryInterface $repository
    ) {}

    public function discover(int $mapId, int $column, int $row): void
    {
        $mapFog = new MapFog([
            'mapId' => $mapId,
            'mapColumn' => $column,
            'mapRow' => $row
        ]);
        $this->repository->discover($mapFog);
    }

    public function discoverMany(int $mapId, array $cells): void
    {
        foreach ($cells as $cell) {
            $this->discover($mapId, $cell['column'], $cell['row']);
        }
    }

    public function insert(MapFog $mapFog): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->insert($mapFog);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function delete(MapFog $mapFog): void
    {
        $this->repository->beginTransaction();
        try {
            $this->repository->delete($mapFog);
            $this->repository->commit();
        } catch (\Throwable $e) {
            $this->repository->rollBack();
            throw $e;
        }
    }

    public function deleteWithoutTransaction(MapFog $mapFog): void
    {
        $this->repository->delete($mapFog);
    }

    public function reset(int $mapId): void
    {
        $this->repository->deleteByMapId($mapId);
    }
}
