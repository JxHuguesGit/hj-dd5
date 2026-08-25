<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Entity\Map;
use src\Domain\Entity\MapFog;
use src\Service\Reader\MapFogReader;
use src\Service\Reader\MapTokenReader;
use src\Service\Writer\MapFogWriter;

final class MapFogService
{
    public function __construct(
        private MapFogReader $mapFogReader,
        private MapFogWriter $mapFogWriter,
        private MapTokenReader $mapTokenReader,
    ) {}

    /**
     * Met à jour les cases découvertes à partir des positions des PJ.
     */
    public function updateVisibility(Map $map): void
    {
        $visibleCells = $this->getVisibleCells($map);
        $this->mapFogWriter->discoverMany(
            $map->id,
            $visibleCells
        );
    }

    /**
     * @return array<int, array{column:int,row:int}>
     */
    public function getVisibleCells(Map $map): array
    {
        $visibleCells = [];

        $pjTokens = $this->mapTokenReader->pjTokensByMap($map->id);

        foreach ($pjTokens as $pjToken) {
            $minColumn = max(
                1,
                (int) floor($pjToken->column - $map->visionRange)
            );

            $maxColumn = min(
                $map->mapColumns,
                (int) ceil($pjToken->column + $map->visionRange)
            );

            $minRow = max(
                1,
                (int) floor($pjToken->row - $map->visionRange)
            );

            $maxRow = min(
                $map->mapRows,
                (int) ceil($pjToken->row + $map->visionRange)
            );

            for ($row = $minRow; $row <= $maxRow; $row++) {
                for ($column = $minColumn; $column <= $maxColumn; $column++) {

                    if (
                        $this->getVisionCost(
                            $column,
                            $row,
                            $pjToken->column,
                            $pjToken->row
                        ) > $map->visionRange
                    ) {
                        continue;
                    }

                    $key = $column . ':' . $row;

                    $visibleCells[$key] = [
                        'column' => $column,
                        'row' => $row,
                    ];
                }
            }
        }

        return array_values($visibleCells);
    }

    private function getVisionCost(
        int $column,
        int $row,
        int $originColumn,
        int $originRow
    ): int {
        $dx = abs($column - $originColumn);
        $dy = abs($row - $originRow);

        $diagonal = min($dx, $dy);
        $straight = max($dx, $dy) - $diagonal;

        $diagonalCost =
            intdiv($diagonal, 2) * 3
            + ($diagonal % 2);

        return $straight + $diagonalCost;
    }

    /**
     * @return array
     */
    public function getDiscoveredCells(Map $map): array
    {
        $mapFogs = $this->mapFogReader->mapFogsByMap($map->id);

        $cells = [];

        foreach ($mapFogs as $mapFog) {
            $cells[] = [
                'column' => $mapFog->mapColumn,
                'row' => $mapFog->mapRow,
            ];
        }

        return $cells;
    }

    public function reset(int $mapId): void
    {
        $this->mapFogWriter->reset($mapId);
    }
}
