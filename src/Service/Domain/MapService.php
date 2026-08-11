<?php
namespace src\Service\Domain;

use src\Constant\Field as F;
use src\Domain\Entity\Map;
use src\Factory\WriterFactory as WF;
use src\Service\Reader\MapReader;

final class MapService
{
    public function __construct(
        private MapReader $mapReader,
        private WF $writerFactory,
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
}
