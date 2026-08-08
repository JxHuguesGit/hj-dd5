<?php
namespace src\Page\Renderer;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\MapTokenService;

class PageMap
{
    public function __construct(
        private TemplateRenderer $renderer,
        private MapTokenService $mapTokenService
    ) {}

    public function render(bool $isMj): string
    {
        $template = $isMj ? Template::MAP_PAGE_MJ : Template::MAP_PAGE_PJ;

        // TODO $mapId !
        $tokens = $this->mapTokenService->buildTokens(1);

        return $this->renderer->render(
            $template,
            [
                PLUGINS_DD5 . 'assets/map/map-002.png',
                json_encode($tokens, JSON_THROW_ON_ERROR),
            ]
        );
    }
}
