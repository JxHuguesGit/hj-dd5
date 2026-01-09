<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Service\Reader\ToolReader;

final class PublicItemTool extends PublicBase
{
    private ?Collection $tools = null;

    public function __construct(
        private ToolReader $toolQueryService,
        private ToolListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->tools = $this->toolQueryService->getAllTools();
        $this->title = Language::LG_TOOLS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_ITEMS);
        $viewData = $this->presenter->present($this->tools);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
