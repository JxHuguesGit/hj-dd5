<?php

namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Presenter\MenuPresenter\CharacterMenuPresenter;
use src\Presenter\MenuPresenter\CompendiumMenuPresenter;
use src\Presenter\MenuPresenter\MapMenuPresenter;
use src\Presenter\MenuPresenter\TimelineMenuPresenter;
use src\Security\Capabilities;

class AdminSidebar extends Utilities
{
    private const TAB_CAPABILITIES = [
        C::HOME           => Capabilities::ACCESS,
        C::ONG_CHARACTER  => Capabilities::CHARACTER,
        C::ONG_TIMELINE   => Capabilities::TIMELINE,
        C::ONG_MAP        => Capabilities::MAP,
        C::ONG_COMPENDIUM => Capabilities::COMPENDIUM,
    ];

    public function __construct(
        private CharacterMenuPresenter $characterMenuPresenter,
        private TimelineMenuPresenter $timelineMenuPresenter,
        private MapMenuPresenter $mapMenuPresenter,
        private CompendiumMenuPresenter $compendiumMenuPresenter,
        private \Closure $renderer,
        private array $params,
    ) {}

    private function canAccess(string $tab): bool
    {
        $capability = self::TAB_CAPABILITIES[$tab] ?? null;

        return $capability === null
            || current_user_can($capability);
    }

    public function getContent(): string
    {
        $currentTab = $this->params[C::ONGLET] ?? C::HOME;

        if (! $this->canAccess($currentTab)) {
            wp_die('Accès refusé');
        }

        $currentId = $this->params[C::ID] ?? '';

        $menu = '';

        if ($this->canAccess(C::ONG_CHARACTER)) {
            $menu .= $this->characterMenuPresenter->render(
                $currentTab,
                $currentId,
                $this->renderer
            );
        }

        if ($this->canAccess(C::ONG_TIMELINE)) {
            $menu .= $this->timelineMenuPresenter->render(
                $currentTab,
                $this->renderer
            );
        }

        if ($this->canAccess(C::ONG_MAP)) {
            $menu .= $this->mapMenuPresenter->render(
                $currentTab,
                $currentId,
                $this->renderer
            );
        }

        if ($this->canAccess(C::ONG_COMPENDIUM)) {
            $menu .= $this->compendiumMenuPresenter->render(
                $currentTab,
                $currentId,
                $this->renderer
            );
        }

        $attributes = [
            $currentTab === C::HOME ? C::ACTIVE : '',
            $menu,
        ];

        return $this->getRender(Template::ADMINSIDEBAR, $attributes);
    }
}
