<?php

namespace src\Controller\Public;

use src\Page\PageList;
use src\Presenter\ListPresenter\RuleListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Domain\WpPostService;

class PublicRule extends PublicBase
{
    public function __construct(
        private WpPostService $wordPress,
        private RuleListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
        private string $categoryTitle
    ) {}

    public function getContentPage(): string
    {
        $posts = $this->wordPress->getPostsByCategoryWithNoChildren($this->categoryTitle);
        $viewData = $this->presenter->present($posts);
        return $this->page->render(
            $this->menuPresenter->render(),
            $this->categoryTitle,
            $viewData
        );
    }
}
