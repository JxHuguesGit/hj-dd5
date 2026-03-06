<?php
namespace src\Page\Renderer;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
                $data[C::TITLE] ?? '',
                $data[C::DESCRIPTION] ?? '',
                implode(', ', $data[C::ABILITIES]),
                $this->formatSkills($data[C::SKILLS]),
                $this->formatLink($data[C::FEAT], fn($slug) => UrlGenerator::feat($slug)),
                $this->formatLink($data[C::TOOL], fn($slug) => UrlGenerator::item($slug)),
                implode(', ', $data[C::EQUIPMENT]),
                'col-width' => 'col-sm-6',
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
                B::TEXT_DARK
            );
        }
        return implode(', ', $parts);
    }

    private function formatLink(?array $entityData, callable $urlGenerator): string
    {
        if (! $entityData) {
            return '-';
        }

        return Html::getLink(
            $entityData[C::NAME],
            $urlGenerator($entityData[C::SLUG]),
            B::TEXT_DARK
        );
    }
}
