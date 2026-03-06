<?php
namespace src\Service\Page;

use src\Constant\Constant as C;
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
            $nav[C::PREV] ? $this->presenter->present($nav[C::PREV]) : null,
            $nav[C::NEXT] ? $this->presenter->present($nav[C::NEXT]) : null
        );
    }
}
