<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Domain\Spell as DomainSpell;
use src\Page\PageSpell;
use src\Presenter\MenuPresenter;
use src\Service\Domain\SpellService;
use src\Service\Page\SpellPageService;

class PublicSpell extends PublicBase
{
    private ?DomainSpell $spell;

    public function __construct(
        private string $slug,
        private MenuPresenter $menuPresenter,
        private PageSpell $page,
        private SpellService $spellService,
        private SpellPageService $pageService,
    ) {
        $this->spell = $this->spellService->spellBySlug($this->slug);
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SPELLS);
        $pageView = $this->pageService->build($this->spell);
        return $this->page->render($menu, $pageView);
    }
}
