<?php

namespace src\Presenter\ContentBuilder;

use Override;
use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Service\Domain\WpPostService;
use src\Utils\Html;

final class HomebrewCardContentBuilder
extends AbstractCardContentBuilder
{
    private Collection $homebrewCollection;

    public function __construct(
        private WpPostService $wpPostServices
    ) {}

    public function build(object $groups): string
    {
        // Id du post Homebrew
        $wpPost = $this->wpPostServices->getById(2135);

        $this->homebrewCollection = new Collection();
        $gridHtml = '';
        foreach ($groups as $group) {
            $gridHtml .= $this->renderGroup($group);
        }

        $contentHtml = $this->getSidebar() . $gridHtml;

        return Html::getDiv(
            $this->renderCard(
                apply_filters('the_content', $wpPost->post_content),
                B::GLOSSAIRE_CARD
            ),
            [C::CSSCLASS => $this->getGroupsClass()]
        ) .
            Html::getDiv(
                $contentHtml,
                [
                    C::CSSCLASS => $this->getGroupsClass(),
                    C::STYLE    => 'flex-direction: row;'
                ]
            );
    }

    protected function renderGroup(object $group): string
    {
        $content = '<article class="data-card glossaire-card">';
        $content .= Html::getBalise(
            H::BALISE_H2,
            'Définitions des règles',
            [
                C::CSSCLASS => B::DATA_GROUP_TITLE,
                C::ID       => 'RulesDefinitions',
            ]
        );
        $content .= Html::getBalise('p', 'Voici les définitions de certaines règles.');
        $content .= '</article>';

        foreach ($group->rows as $row) {
            $content .= $this->renderItem($row);
        }

        $grid = Html::getDiv(
            $content,
            [C::CSSCLASS => $this->getGridClass()]
        );

        return Html::getBalise(
            H::BALISE_SECTION,
            $this->renderGroupTitle($group) . $grid,
            [
                C::CSSCLASS => $this->getGroupClass(),
                C::ID => $this->getGroupId($group),
            ]
        );
    }

    private function getSidebar(): string
    {
        $sidebar = '<section class="secondary-content" role="complementary">
            <div class="sidebar-menu">
                <div class="sidebar-scroll-menu">
                    <ul class="quick-menu quick-menu-tier-1">
                        <li class="quick-menu-item quick-menu-item-tier-1 quick-menu-item-opened">
                            <ul class="quick-menu quick-menu-tier-2">
                                <li class="quick-menu-item quick-menu-item-tier-2 quick-menu-item-closed">
                                    <div class="quick-menu-item-label"><a class="quick-menu-item-link" href="#GlossaryConventions">Conventions du Glossaire</a></div>
                                </li>
                                <li class="quick-menu-item quick-menu-item-tier-2 quick-menu-item-opened">
                                    <div class="quick-menu-item-label">
                                        <a class="quick-menu-item-link" href="#RulesDefinitions">Définitions des règles</a>
                                        <div class="quick-menu-item-trigger"></div>
                                    </div>
                                    <ul class="quick-menu quick-menu-tier-3">';

        foreach ($this->homebrewCollection as $row) {
            $title = $row->title;
            if (strpos($title, ' [') !== false) {
                $title = substr($title, 0, strpos($title, ' ['));
            }
            $sidebar .= '<li class="quick-menu-item quick-menu-item-tier-3 quick-menu-item-closed"><div class="quick-menu-item-label"><a class="quick-menu-item-link" href="#' . $row->anchor . '">' . $title . '</a></div></li>';
        }

        $sidebar .= '               </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </section>';

        return $sidebar;
    }

    protected function renderItem(object $row): string
    {
        $this->homebrewCollection->add($row);

        $htmlContent = Html::getBalise(
            'hr',
            '',
            [
                C::CSSCLASS => 'separator',
                C::ID       => $row->anchor
            ]
        );

        $badge = '';
        if ($row->new) {
            $badge .= Html::getSpan(
                'New',
                [C::CSSCLASS => 'badge bg-primary ml-5 float-end']
            );
        }
        if ($row->refonte) {
            $badge .= Html::getSpan(
                'Refonte',
                [C::CSSCLASS => 'badge bg-danger ml-5 float-end']
            );
        }

        $cardContent =
            Html::getBalise(
                H::BALISE_H3,
                $row->title . $badge
            )  .
            Html::getBalise(
                H::BALISE_DIV,
                $row->content
            );

        return $htmlContent .
            $this->renderCard(
                $cardContent,
                B::GLOSSAIRE_CARD
            );
    }

    protected function getGroupId(object $group): string
    {
        return '';
    }

    #[Override]
    protected function getGridClass(): string
    {
        return 'glossary-grid';
    }

    #[Override]
    protected function getGroupClass(): string
    {
        return 'glossary-group max-width-850 primary-content';
    }
}
