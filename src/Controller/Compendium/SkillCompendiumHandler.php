<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\SkillReader;

class SkillCompendiumHandler extends AbstractCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private SkillReader $reader,
        private SkillListPresenter $presenter,
        private TemplateRenderer $templateRenderer,
    ) {}

    public function renderList(): string
    {
        $skills         = $this->reader->allParentSkills();
        $presentContent = $this->presenter->present($skills);
        $page           = new PageList(
            $this->templateRenderer,
            new SkillTableBuilder(false)
        );
        return $page->renderAdmin('', $presentContent, $this->toastContent);

    }

    protected function renderEdit(int $id): string { return (string)$id; }
    protected function renderCreate(): string { return ''; }
    protected function handleEditSubmit(int $id): string { return (string)$id; }
    protected function handleNewSubmit(): string { return ''; }
}
