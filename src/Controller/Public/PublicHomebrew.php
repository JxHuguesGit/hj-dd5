<?php
namespace src\Controller\Public;

use src\Constant\Language as L;
use src\Page\PageList;
use src\Presenter\ListPresenter\HomebrewListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Domain\WpPostService;

class PublicHomebrew extends PublicBase
{
    public function __construct(
        private WpPostService $wordPress,
        private HomebrewListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = L::HOMEBREW_TITLE;
    }

    public function getContentPage(): string
    {
        $posts = $this->wordPress->getPostsByCategory('Homebrew');
        $viewData = $this->presenter->present($posts);

        return $this->page->render(
            $this->menuPresenter->render(),
            $this->title,
            $viewData
        );
    }

}
