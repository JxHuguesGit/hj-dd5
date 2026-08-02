<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class OriginDetailContentBuilder implements ContentBuilderInterface
{
    public function build(mixed $data, array $params = []): string
    {
        return Html::getBalise(
            'section',
            $this->renderContent($data),
            [C::CSSCLASS => 'origin-detail']
        );
    }

    private function renderContent(array $data): string
    {
        return
            $this->renderHeader($data)
            . $this->renderDescription($data)
            . $this->renderProperties($data)
            //. $this->renderAbilities($data)
            . $this->renderEquipment($data)
            . $this->renderNavigation($data);
    }

    private function renderHeader(array $view): string
    {
        return Html::getBalise(
            'header',
            Html::getBalise(
                'h1',
                htmlspecialchars($view[C::TITLE] ?? '')
            ),
            ['class' => 'origin-detail-header']
        );
    }

    private function renderDescription(array $view): string
    {
        if (($view[C::DESCRIPTION] ?? '') === '') {
            return '';
        }

        return Html::getDiv(
            $view[C::DESCRIPTION],
            ['class' => 'origin-description']
        );
    }

    private function renderProperties(array $view): string
    {
        $content = '';

        $content .= $this->renderProperty(
            'Capacités',
            implode(', ', $view[C::ABILITIES] ?? [])
        );

        $content .= $this->renderProperty(
            'Compétences',
            $this->formatSkills($view[C::SKILLS] ?? [])
        );

        $content .= $this->renderProperty(
            'Don d\'origine',
            $this->formatLink(
                $view[C::FEAT] ?? null,
                fn(string $slug) => UrlGenerator::feat($slug)
            )
        );

        $content .= $this->renderProperty(
            'Outil',
            $this->formatLink(
                $view[C::TOOL] ?? null,
                fn(string $slug) => UrlGenerator::item($slug)
            )
        );

        if ($content === '') {
            return '';
        }

        return Html::getDiv(
            $content,
            ['class' => 'origin-properties']
        );
    }

    private function renderProperty(string $label, string $value): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getDiv(
            '<strong>' . htmlspecialchars($label) . ' :</strong> ' . $value,
            ['class' => 'origin-property']
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
        ?array $entityData,
        callable $urlGenerator
    ): string {
        if (!$entityData) {
            return '-';
        }

        return Html::getLink(
            htmlspecialchars($entityData[C::NAME]),
            $urlGenerator($entityData[C::SLUG]),
            B::TEXT_DARK
        );
    }

    private function renderEquipment(array $view): string
    {
        $equipment = $view[C::EQUIPMENT] ?? [];

        if (!$equipment) {
            return '';
        }

        return Html::getDiv(
            implode(', ', $equipment),
            ['class' => 'origin-equipment']
        );
    }

    private function renderNavigation(array $view): string
    {
        $content = '';

        if (!empty($view[C::PREV])) {
            $content .= Html::getLink(
                '&lt; ' . htmlspecialchars($view[C::PREV][C::NAME]),
                UrlGenerator::origin($view[C::PREV][C::SLUG]),
                'btn btn-sm btn-outline-dark'
            );
        }

        if (!empty($view[C::NEXT])) {
            $content .= Html::getLink(
                htmlspecialchars($view[C::NEXT][C::NAME]) . ' &gt;',
                UrlGenerator::origin($view[C::NEXT][C::SLUG]),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($content === '') {
            return '';
        }

        $class = 'origin-navigation';

        if (empty($view[C::PREV])) {
            $class .= ' only-next';
        }

        if (empty($view[C::NEXT])) {
            $class .= ' only-prev';
        }

        return Html::getDiv(
            $content,
            ['class' => $class]
        );
    }
}
