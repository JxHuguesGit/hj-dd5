<?php
namespace src\Page\Renderer;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class PageOrigine extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::origin($slug);
    }

    public function render(string $menuHtml, array $data): string
    {
        return $this->renderDetail(
            $menuHtml,
            $data,
            Template::ORIGIN_DETAIL_CARD,
            [
                '',
                $data[Constant::CST_TITLE] ?? '',
                $data[Constant::CST_DESCRIPTION] ?? '',
                implode(', ', $data[Constant::CST_ABILITIES]),
                $this->formatSkills($data[Constant::CST_SKILLS]),
                $this->formatLink($data[Constant::CST_FEAT], fn($slug) => UrlGenerator::feat($slug)),
                $this->formatLink($data[Constant::CST_TOOL], fn($slug) => UrlGenerator::item($slug)),
                implode(', ', $data[Constant::CST_EQUIPMENT]),
            ]
        );
    }

    private function formatSkills(Collection $skills): string
    {
        $parts = [];
        foreach ($skills as $skill) {
            $parts[] = Html::getLink(
                $skill->name,
                UrlGenerator::skill($skill->getSlug()),
                Bootstrap::CSS_TEXT_DARK
            );
        }
        return implode(', ', $parts);
    }

    private function formatLink(?array $entityData, callable $urlGenerator): string
    {
        if (!$entityData) {
            return '-';
        }

        return Html::getLink(
            $entityData[Constant::CST_NAME],
            $urlGenerator($entityData[Constant::CST_SLUG]),
            Bootstrap::CSS_TEXT_DARK
        );
    }
}
