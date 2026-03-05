<?php
namespace src\Page\Renderer;

use src\Constant\Constant;
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
                $data[Constant::TITLE] ?? '',
                $data[Constant::ABILITIES] ?? '',
                $data[Constant::DESCRIPTION] ?? '',
                $data[Constant::ORIGINES] ?? [],
                $data[Constant::SUBSKILLS] ?? [],
            ]
        );
    }
}
