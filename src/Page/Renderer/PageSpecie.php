<?php
namespace src\Page\Renderer;

use src\Constant\Constant;
use src\Constant\Template;
use src\Utils\UrlGenerator;

class PageSpecie extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::specie($slug);
    }

    public function render(string $menuHtml, array $data): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::SPECIE_DETAIL_CARD,
            [
                $data[Constant::TITLE] ?? '',
                $data[Constant::DESCRIPTION] ?? '',
                $data[Constant::CREATURE_TYPE] ?? '-',
                $data[Constant::SIZE_CATEGORY] ?? '-',
                $data[Constant::SPEED] ?? '-',
                $data[Constant::POWERS] ?? '-',
            ]
        );
    }
}
