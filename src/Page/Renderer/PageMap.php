<?php
namespace src\Page\Renderer;

use src\Constant\Template;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\MapTokenService;

class PageMap
{
    public function __construct(
        private Map $map,
        private TemplateRenderer $renderer,
        private MapTokenService $mapTokenService
    ) {}

    public function render(bool $isMj): string
    {
        $template = $isMj ? Template::MAP_PAGE_MJ : Template::MAP_PAGE_PJ;

        $tokens = $this->mapTokenService->buildTokens($this->map->id);

        return $this->renderer->render(
            $template,
            [
                $this->map->id,
                PLUGINS_DD5 . 'assets/map/' . $this->map->image,
                $this->map->mapColumns,
                $this->map->mapRows,
                $this->map->cellSize,
                json_encode($tokens, JSON_THROW_ON_ERROR),
            ]
        );
    }
}
