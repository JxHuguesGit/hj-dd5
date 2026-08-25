<?php
namespace src\Controller\Admin;


use src\Constant\Template;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;


final class AdminMapView
{
    public function __construct(
        private TemplateRenderer $renderer,
    ) {}

    public function getContent(
        Map $map,
        array $tokens,
        array $visibleCells,
        array $discoveredCells,
    ): string {
        return $this->renderer->render(
            Template::MAP_PAGE_MJ,
            [
                $map->id,
                PLUGINS_DD5 . 'assets/map/' . $map->image,
                $map->mapColumns,
                $map->mapRows,
                $map->cellSize,
                json_encode($tokens, JSON_THROW_ON_ERROR),
                json_encode($visibleCells, JSON_THROW_ON_ERROR),
                json_encode($discoveredCells, JSON_THROW_ON_ERROR),
            ]
        );
    }
}
