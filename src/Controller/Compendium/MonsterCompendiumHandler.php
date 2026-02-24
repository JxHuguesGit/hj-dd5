<?php
namespace src\Controller\Compendium;

use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\MonsterFormBuilder;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\MonsterReader;

class MonsterCompendiumHandler extends AbstractCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private MonsterReader $reader,
        private MonsterListPresenter $presenter,
        private PageList $page,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    protected function handleEditSubmit(string $slug): string
    {
        // Aucune valeur n'a été modifiée pour être enregistrée
        $this->toastContent = $this->toastBuilder->info("Non développé pour le moment.");
        return $this->renderEdit($slug);
    }

    protected function renderEdit(string $slug): string
    {
        $monster = $this->reader->monsterByUkTag($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new MonsterFormBuilder(),
            $this->toastContent
        );
        return $page->renderAdmin('', $monster);
    }

    protected function renderList(): string
    {
        $monsters       = $this->reader->allMonsters();
        $presentContent = $this->presenter->present($monsters);
        return $this->page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
