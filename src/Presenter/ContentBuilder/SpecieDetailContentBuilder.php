<?php

namespace src\Presenter\ContentBuilder;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\AbilityOptionView;
use src\Presenter\ViewModel\AbilityView;
use src\Presenter\ViewModel\SpecieDetailView;
use src\Service\Formatter\ShortcodeFormatter;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SpecieDetailContentBuilder extends AbstractDetailContentBuilder
{
    public function __construct(
        private ShortcodeFormatter $shortcodeFormatter
    ) {}

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::specie($slug);
    }

    /** @param SpecieDetailView $view */
    protected function renderDetailBody(object $view) : string
    {
        return
            $this->renderProperties($view)
            . $this->renderDescription($view)
            . $this->renderAbilities($view->abilities)
        ;
    }

    private function renderProperties(SpecieDetailView $view): string
    {
        $content = '';

        if ($view->creatureType !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(L::STRONG_INFO, L::TYPE . L::COLON, htmlspecialchars($view->creatureType))
            );
        }

        if ($view->sizeCategory !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(L::STRONG_INFO, L::HEIGHT . L::COLON, htmlspecialchars($view->sizeCategory))
            );
        }

        if ($view->speed !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(L::STRONG_INFO, L::SPEED . L::COLON, htmlspecialchars($view->speed))
            );
        }

        if ($content === '') {
            return '';
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::SPECIE_PROPERTIES]
        );
    }

    private function renderDescription(SpecieDetailView $view): string
    {
        return Html::getDiv(
            $view->description,
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION . L::SPACE . B::SPECIE_DESCRIPTION]
        );
    }

    /** @param Collection<AbilityView> $abilities */
    private function renderAbilities(iterable $abilities): string
    {
        if (!$abilities) {
            return '';
        }

        $content = '';

        foreach ($abilities as $ability) {
            $content .= $this->renderAbility($ability);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::SPECIE_ABILITIES]
        );
    }

    private function renderAbility(AbilityView $ability): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            htmlspecialchars($ability->name),
            [C::CSSCLASS => B::ABILITY_TITLE]
        );

        if ($ability->description !== '') {
            $content .= Html::getDiv(
                $this->shortcodeFormatter->parse($ability->description),
                [C::CSSCLASS => B::ABILITY_DESCRIPTION]
            );
        }

        if ($ability->children) {
            $content .= $this->renderChildren($ability->children);
        }

        if ($ability->options) {
            $content .= $this->renderOptions($ability->options);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ABILITY]
        );
    }

    private function renderOption(AbilityOptionView $option): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            htmlspecialchars($option->name),
            [C::CSSCLASS => B::ABILITY_TITLE]
        );

        if ($option->description !== '') {
            $content .= Html::getDiv(
                $this->shortcodeFormatter->parse($option->description),
                [C::CSSCLASS => B::ABILITY_DESCRIPTION]
            );
        }

        $content .= $this->renderChildren($option->abilities);

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ABILITY]
        );
    }

    /** @param Collection<AbilityView> $children */
    private function renderChildren(iterable $children): string
    {
        $content = '';

        foreach ($children as $child) {
            $content .= $this->renderAbility($child);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ABILITY_CHILDREN]
        );
    }

    /** @param Collection<AbilityOptionView> $options */
    private function renderOptions(iterable $options): string
    {
        $content = '';

        foreach ($options as $option) {
            $content .= $this->renderOption($option);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ABILITY_OPTIONS]
        );
    }
}
