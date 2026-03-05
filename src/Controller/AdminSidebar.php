<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Presenter\MenuPresenter\CharacterMenuPresenter;
use src\Presenter\MenuPresenter\CompendiumMenuPresenter;
use src\Presenter\MenuPresenter\TimelineMenuPresenter;

class AdminSidebar extends Utilities
{
    public function __construct(
        private CharacterMenuPresenter $characterMenuPresenter,
        private TimelineMenuPresenter $timelineMenuPresenter,
        private CompendiumMenuPresenter $compendiumMenuPresenter,
        private \Closure $renderer,
        private array $allowedTabs,
        private string $currentTab = '',
        private string $currentId = ''
    ) {}

    public function getContent(): string
    {
        // On ajoute le menu "Character";
        $menu  = $this->characterMenuPresenter->render(
            $this->currentTab,
            $this->currentId,
            $this->renderer
        );
        // On ajoute le menu "Initiative";
        $menu .= $this->timelineMenuPresenter->render(
            $this->currentTab,
            $this->renderer
        );
        // On ajoute le menu "Compendium";
        $menu .= $this->compendiumMenuPresenter->render(
            $this->currentTab,
            $this->currentId,
            $this->renderer
        );

        $attributes = [
            ! in_array($this->currentTab, $this->allowedTabs) || $this->currentTab == Constant::HOME
                ? Constant::ACTIVE
                : '',
            $menu,
        ];
        return $this->getRender(Template::ADMINSIDEBAR, $attributes);
    }
}
