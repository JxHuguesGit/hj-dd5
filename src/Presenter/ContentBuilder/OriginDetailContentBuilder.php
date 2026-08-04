<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ViewModel\LinkView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class OriginDetailContentBuilder extends AbstractDetailContentBuilder
{

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::origin($slug);
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        return
            $this->renderProperties($view)
            . $this->renderDescription($view)
            // . $this->renderAbilities($view)
            . $this->renderEquipment($view)
        ;
    }

    private function renderDescription(object $view): string
    {
        if (($view->description ?? '') === '') {
            return '';
        }

        return Html::getDiv(
            $view->description,
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION . L::SPACE . B::ORIGIN_DESCRIPTION]
        );
    }

    private function renderProperties(object $view): string
    {
        $content = '';

        $content .= $this->renderProperty(
            L::CAPACITES,
            implode(', ', $view->abilities ?? [])
        );

        $content .= $this->renderProperty(
            L::SKILLS,
            $this->formatSkills($view->skills ?? [])
        );

        $content .= $this->renderProperty(
            L::ORIGIN_FEAT,
            $this->formatLink(
                $view->feat ?? null,
                fn(string $slug) => UrlGenerator::feat($slug)
            )
        );

        $content .= $this->renderProperty(
            L::TOOL,
            $this->formatLink(
                $view->tool ?? null,
                fn(string $slug) => UrlGenerator::item($slug)
            )
        );

        if ($content === '') {
            return '';
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ORIGIN_PROPERTIES]
        );
    }

    private function renderProperty(string $label, string $value): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getDiv(
            sprintf(L::STRONG_INFO, htmlspecialchars($label) . L::COLON, $value),
            [C::CSSCLASS => B::ORIGIN_PROPERTY]
        );
    }

    private function formatSkills(iterable $skills): string
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

    private function formatLink(
        ?LinkView $entityData,
        callable $urlGenerator
    ): string {
        if (!$entityData) {
            return L::DASH;
        }

        return Html::getLink(
            htmlspecialchars($entityData->name),
            $urlGenerator($entityData->slug),
            B::TEXT_DARK
        );
    }

    private function renderEquipment(object $view): string
    {
        $equipment = $view->equipment ?? [];

        if (!$equipment) {
            return '';
        }

        return Html::getDiv(
            implode(', ', $equipment),
            [C::CSSCLASS => B::ORIGIN_EQUIPMENT]
        );
    }
}
