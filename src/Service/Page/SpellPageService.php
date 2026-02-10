<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Entity\Spell;
use src\Presenter\Detail\SpellDetailPresenter;
use src\Presenter\ViewModel\SpellPageView;
use src\Service\Domain\SpellService;

final class SpellPageService
{
    public function __construct(
        private SpellService $spellService,
        private SpellDetailPresenter $presenter,
    ) {}

    public function build(Spell $spell): SpellPageView
    {
        $nav = $this->spellService->getPreviousAndNext($spell);

        return new SpellPageView(
            $this->presenter->present($spell),
            $nav[Constant::CST_PREV] ? $this->presenter->present($nav[Constant::CST_PREV]) : null,
            $nav[Constant::CST_NEXT] ? $this->presenter->present($nav[Constant::CST_NEXT]) : null
        );
    }
}
