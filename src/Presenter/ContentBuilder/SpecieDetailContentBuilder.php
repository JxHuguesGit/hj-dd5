<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Presenter\ViewModel\AbilityOptionView;
use src\Presenter\ViewModel\AbilityView;
use src\Presenter\ViewModel\SpecieDetailView;
use src\Service\Formatter\ShortcodeFormatter;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SpecieDetailContentBuilder implements ContentBuilderInterface
{
    public function __construct(
        private ShortcodeFormatter $shortcodeFormatter
    ) {}

    public function build(mixed $data, array $params = []): string
    {
        /** @var SpecieDetailView $data */

        $content = '';

        $content .= Html::getBalise(
            H::BALISE_H1,
            htmlspecialchars($data->name)
        );

        $content .= $this->renderProperties($data);

        $content .= Html::getDiv(
            $data->description,
            [C::CSSCLASS => 'specie-description']
        );

        $content .= $this->renderAbilities($data->abilities);

        $content .= $this->renderNavigation($data);

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'specie-detail']
        );
    }

    private function renderProperties(SpecieDetailView $view): string
    {
        $content = '';

        if ($view->creatureType !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(
                    '<strong>Type :</strong> %s',
                    htmlspecialchars($view->creatureType)
                )
            );
        }

        if ($view->sizeCategory !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(
                    '<strong>Taille :</strong> %s',
                    htmlspecialchars($view->sizeCategory)
                )
            );
        }

        if ($view->speed !== '') {
            $content .= Html::getBalise(
                H::BALISE_P,
                sprintf(
                    '<strong>Vitesse :</strong> %s',
                    htmlspecialchars($view->speed)
                )
            );
        }

        if ($content === '') {
            return '';
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'specie-properties']
        );
    }

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
            [C::CSSCLASS => 'specie-abilities']
        );
    }

    private function renderAbility(AbilityView $ability): string
    {
        $content = '';

        $content .= Html::getBalise(
            H::BALISE_H3,
            htmlspecialchars($ability->name),
            [C::CSSCLASS => 'ability-title']
        );

        if ($ability->description !== '') {
            $content .= Html::getDiv(
                $this->shortcodeFormatter->parse($ability->description),
                [C::CSSCLASS => 'ability-description']
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
            [C::CSSCLASS => 'ability']
        );
    }

    private function renderOption(AbilityOptionView $option): string
    {
        $content = '';

        $content .= Html::getBalise(
            H::BALISE_H3,
            htmlspecialchars($option->name),
            [C::CSSCLASS => 'ability-title']
        );

        if ($option->description !== '') {
            $content .= Html::getDiv(
                $this->shortcodeFormatter->parse($option->description),
                [C::CSSCLASS => 'ability-description']
            );
        }

        $content .= $this->renderChildren($option->abilities);

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'ability']
        );
    }
    
    private function renderChildren(iterable $children): string
    {
        $content = '';

        foreach ($children as $child) {
            $content .= $this->renderAbility($child);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'ability-children']
        );
    }

    private function renderOptions(iterable $options): string
    {
        $content = '';

        foreach ($options as $option) {
            $content .= $this->renderOption($option);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => 'ability-options']
        );
    }


    private function renderNavigation(SpecieDetailView $view): string
    {
        $content = '';

        if ($view->previous) {
            $content .= Html::getLink(
                '&lt; ' . htmlspecialchars($view->previous->name),
                UrlGenerator::specie($view->previous->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($view->next) {
            $content .= Html::getLink(
                htmlspecialchars($view->next->name) . ' &gt;',
                UrlGenerator::specie($view->next->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($content === '') {
            return '';
        }

        $class = 'specie-navigation';

        if (!$view->previous) {
            $class .= ' only-next';
        }

        if (!$view->next) {
            $class .= ' only-prev';
        }

        return Html::getDiv(
            $content,
            ['class' => $class]
        );
    }
}
