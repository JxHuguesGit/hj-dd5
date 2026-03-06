<?php
namespace src\Page\Renderer;

use src\Constant\Constant as C;
use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageSkill extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::skill($slug);
    }

    public function render(string $menuHtml, array $data): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::SKILL_DETAIL_CARD,
            [
                $data[C::TITLE] ?? '',
                $data[C::ABILITIES] ?? '',
                $data[C::DESCRIPTION] ?? '',
                $data[C::ORIGINES] ?? [],
                $data[C::SUBSKILLS] ?? [],
            ]
        );
    }
}
