<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Service\Reader\ToolReader;

final class ToolCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private ToolReader $reader,
        private ToolListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $tools = $this->reader->allTools();
        $content   = $this->presenter->present($tools);
        return $this->page->renderAdmin('', $content);
    }
}
