<?php
namespace src\Controller\Compendium;

use src\Domain\Criteria\ToolCriteria;
use src\Page\PageList;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Repository\ToolRepository;

final class ToolCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private ToolRepository $repository,
        private ToolListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $tools = $this->repository->findAllWithRelations(new ToolCriteria());
        $content   = $this->presenter->present($tools);
        return $this->page->renderAdmin('', $content);
    }
}
