<?php
namespace src\Page\Renderer;

use src\Constant\Constant as C;
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
                $data[C::TITLE] ?? '',
                $data[C::DESCRIPTION] ?? '',
                $data[C::CREATURE_TYPE] ?? '-',
                $data[C::SIZE_CATEGORY] ?? '-',
                $data[C::SPEED] ?? '-',
                $data[C::POWERS] ?? '-',
            ]
        );
    }
}
