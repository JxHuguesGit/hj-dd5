<?php
namespace src\Controller\Compendium;

use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Spell;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\SpellFormBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Service\Reader\SpellReader;

final class SpellCompendiumHandler
    extends AbstractCompendiumHandler
    implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private SpellService $spellService,
        private SpellListPresenter $spellListPresenter,
        private TemplateRenderer $templateRenderer,
        private SpellFormBuilder $spellFormBuilder,
    ) {}

    protected function renderEdit(?int $slug = 0): string
    {
        if ($slug===0) {
            $spell = new Spell();
        } else {
            //$spell = $this->featReader->featById($slug);
        }

        $page = new PageForm(
            $this->templateRenderer,
            $this->spellFormBuilder,
            $this->toastContent
        );

        return $page->renderAdmin('', $spell);
    }

    protected function renderList(): string
    {
        $criteria = new SpellCriteria();
        $result   = $this->spellService->allSpells($criteria);
        $presentContent = $this->spellListPresenter->present($result->collection);

        $page = new PageList(
            $this->templateRenderer,
            new SpellTableBuilder(true)
        );

        return $page->renderAdmin(
            '',
            $presentContent,
            $this->toastContent
        );
    }
}
