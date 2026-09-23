<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Language as L;
use src\Constant\Template;
use src\Domain\Result\SpellResult;
use src\Presenter\ContentBuilder\SpellCardContentBuilder;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;

class PublicSpells extends PublicBase
{
    private ?SpellResult $spellResult = null;

    public function __construct(
        private SpellService $spellService,
        private SpellListPresenter $presenter,
        private SpellCardContentBuilder $spellCardContentBuilder,
        private TemplateRenderer $renderer,
        private MenuPresenter $menuPresenter,
        private SpellFilterModalPresenter $filterModalPresenter,
    ) {
        $this->spellResult = $this->spellService->allSpells();
        $this->title = L::SPELLS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();
        $viewData = $this->presenter->present($this->spellResult->collection);
        $modalContent = $this->filterModalPresenter->render();
        return $this->render($menu, $this->title, $viewData, $modalContent);
    }

    private function render(
        string $menu,
        string $title,
        Collection $viewData,
        string $modalContent
    ): string
    {
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [
                $menu,
                $this->renderAdmin(
                    $title,
                    $viewData,
                    $modalContent ?? ''
                ),
                ''
            ]
        );
    }

    public function renderAdmin(
        string $title,
        Collection $viewData,
        ?string $modalContent = null,
        ?string $toastContent = null
    ): string
    {
        // Construire le tableau
        $contentHtml = $this->spellCardContentBuilder->build(
            $viewData,
            $this->spellResult->hasMore
        );

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$title, $contentHtml, $toastContent, $modalContent]
        );
    }
}
