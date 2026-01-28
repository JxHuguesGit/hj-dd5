<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Presenter\ViewModel\SpellDetail;
use src\Presenter\ViewModel\SpellPageView;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class PageSpell extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::spell($slug);
    }
    
    public function render(string $menuHtml, SpellPageView $view): string
    {
        $spell = $view->spell;
        $prevHtml = $this->renderNavLink($view->previous, true);
        $nextHtml = $this->renderNavLink($view->next, false);

        return $this->renderDetailTemporaire(
            $menuHtml,
            Template::SPELL_DETAIL_CARD,
            [
                $spell->name,
                SpellFormatter::formatEcole($spell->ecole, $spell->niveau) .
                    '<br>' . SpellFormatter::formatClasses($spell->classes),

                SpellFormatter::formatDuree($spell->duree, $spell->concentration),
                SpellFormatter::formatPortee($spell->portee),

                SpellFormatter::formatIncantation($spell->tpsInc, $spell->rituel),
                '',

                SpellFormatter::formatComposantes($spell->composantes, $spell->composanteMaterielle, true),

                $spell->description,

                $prevHtml,
                $nextHtml,
            ]
        );
    }

    protected function renderDetailTemporaire(
        string $menuHtml,
        string $detailTemplate,
        array $detailFields
    ): string
    {
        $detailCard = $this->renderer->render(
            $detailTemplate,
            $detailFields
        );

        $contentSection = $this->renderer->render(
            Template::DETAIL_PAGE,
            ['', $detailCard]
        );

        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $contentSection, '']
        );
    }

    private function renderNavLink(
        ?SpellDetail $navData,
        bool $isPrev
    ): string
    {
        if (!$navData) {
            return Constant::CST_EMPTY_SPAN;
        }

        $label = $isPrev
            ? '&lt; ' . $navData->name
            : $navData->name . ' &gt;';

        return Html::getLink(
            $label,
            $navData->url,
            implode(' ', [
                Bootstrap::CSS_BTN,
                Bootstrap::CSS_BTN_SM,
                Bootstrap::CSS_BTN_OUTLINE_DARK
            ])
        );
    }

}
