<?php
namespace src\Page\Renderer;

use src\Constant\Template;

class PageNotFound extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return '#';
    }

    public function render(string $menuHtml, array $data = []): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::NOT_FOUND_CARD,
            ['Page non trouvée', 'La page demandée est introuvable.']
        );
    }
}
