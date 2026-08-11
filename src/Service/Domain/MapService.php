<?php
namespace src\Service\Domain;

use src\Constant\Field as F;
use src\Domain\Entity\Map;
use src\Domain\Entity\MapToken;
use src\Exception\MapActiveException;
use src\Exception\MapNotFoundException;
use src\Factory\WriterFactory as WF;
use src\Service\Reader\MapReader;
use src\Service\Reader\MapTokenReader;

final class MapService
{
    public function __construct(
        private MapReader $mapReader,
        private WF $writerFactory,
        private MapTokenReader $mapTokenReader,
    ) {}

    public function activate(int $mapId): void
    {
        $map = $this->mapReader->mapById($mapId);

        if ($map === null) {
            throw new \InvalidArgumentException(
                "La map $mapId n'existe pas."
            );
        }

        $activeMap = $this->mapReader->getActiveMap();

        if ($activeMap?->id === $mapId) {
            return;
        }

        $this->writerFactory
            ->map()
            ->activate($map, $activeMap);
    }

    public function lock(Map $map): void
    {
        $map->locked = 1;

        $this->writerFactory->map()->updatePartial(
            $map,
            [F::LOCKED]
        );
    }

    public function unlock(Map $map): void
    {
        $map->locked = 0;

        $this->writerFactory->map()->updatePartial(
            $map,
            [F::LOCKED]
        );
    }

    public function assertUnlocked(Map $map): void
    {
        if ($map->locked) {
            throw new \LogicException(
                'Cette map est verrouillée.'
            );
        }
    }

    public function duplicate(int $mapId): Map
    {
        $map = $this->mapReader->mapById($mapId);
        if ($map === null) {
            throw new MapNotFoundException($mapId);
        }

        $tokens = $this->mapTokenReader->mapTokensByMap($mapId);

        $newMap = new Map([
            F::NAME       => $map->name . ' - Copie',
            F::IMAGE      => $map->image,
            F::MAPCOLUMNS => $map->mapColumns,
            F::MAPROWS    => $map->mapRows,
            F::CELLSIZE   => $map->cellSize,
            F::ACTIVE     => 0,
            F::LOCKED     => 0,
        ]);

        $mapWriter = $this->writerFactory->map();
        $mapTokenWriter = $this->writerFactory->mapToken();
        $mapWriter->beginTransaction();

        try {
            $mapWriter->insertWithoutTransaction($newMap);

            foreach ($tokens as $token) {
                $newToken = new MapToken([
                    F::MAPID   => $newMap->id,
                    F::TOKENID => $token->tokenId,
                    F::COLUMN  => $token->column,
                    F::ROW     => $token->row,
                    F::SIZE    => $token->size,
                    F::NUMBER  => $token->number,
                ]);

                $mapTokenWriter->insertWithoutTransaction($newToken);
            }
            $mapWriter->commit();

            return $newMap;
        } catch (\Throwable $e) {
            $mapWriter->rollBack();
            throw $e;
        }
    }

    public function delete(int $mapId): void
    {
        $map = $this->mapReader->mapById($mapId);

        if ($map === null) {
            throw new MapNotFoundException($mapId);
        }

        $this->assertUnlocked($map);

        if ($map->active) {
            throw new MapActiveException($mapId);
        }

        $tokens = $this->mapTokenReader->mapTokensByMap($mapId);

        $mapWriter = $this->writerFactory->map();
        $mapTokenWriter = $this->writerFactory->mapToken();

        $mapWriter->beginTransaction();

        try {
            foreach ($tokens as $token) {
                $mapTokenWriter->deleteWithoutTransaction($token);
            }
            $mapWriter->deleteWithoutTransaction($map);

            $mapWriter->commit();
        } catch (\Throwable $e) {
            $mapWriter->rollBack();
            throw $e;
        }
    }
}
