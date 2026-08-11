<?php
namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Presenter\MenuPresenter\CharacterMenuPresenter;
use src\Presenter\MenuPresenter\CompendiumMenuPresenter;
use src\Presenter\MenuPresenter\MapMenuPresenter;
use src\Presenter\MenuPresenter\TimelineMenuPresenter;

class AdminSidebar extends Utilities
{
    private array $allowedOnglets = [
        C::HOME,
        C::ONG_CHARACTER,
        C::ONG_TIMELINE,
        C::ONG_MAP,
        C::ONG_COMPENDIUM,
    ];

    public function __construct(
        private CharacterMenuPresenter $characterMenuPresenter,
        private TimelineMenuPresenter $timelineMenuPresenter,
        private MapMenuPresenter $mapMenuPresenter,
        private CompendiumMenuPresenter $compendiumMenuPresenter,
        private \Closure $renderer,
        private array $params,
    ) {}

    public function getContent(): string
    {
        $currentTab = $this->params[C::ONGLET] ?? C::HOME;
        $currentId  = $this->params[C::ID] ?? '';

        // On ajoute le menu "Character";
        $menu  = $this->characterMenuPresenter->render(
            $currentTab,
            $currentId,
            $this->renderer
        );
        // On ajoute le menu "Initiative";
        $menu .= $this->timelineMenuPresenter->render(
            $currentTab,
            $this->renderer
        );
        // On ajoute le menu "map";
        $menu .= $this->mapMenuPresenter->render(
            $currentTab,
            $currentId,
            $this->renderer
        );
        // On ajoute le menu "Compendium";
        $menu .= $this->compendiumMenuPresenter->render(
            $currentTab,
            $currentId,
            $this->renderer
        );

        $attributes = [
            ! in_array($currentTab, $this->allowedOnglets) || $currentTab == C::HOME
                ? C::ACTIVE
                : '',
            $menu,
        ];
        return $this->getRender(Template::ADMINSIDEBAR, $attributes);
    }
}
