<?php
namespace src\Controller\Public;

use src\Page\PageList;
use src\Presenter\ListPresenter\GlossaireListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Domain\WpPostService;

class PublicGlossaire extends PublicBase
{
    public function __construct(
        private WpPostService $wordPress,
        private GlossaireListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = 'Glossaire';
    }

    public function getContentPage(): string
    {
        $posts = $this->wordPress->getPostsByCategory('Glossaire');
        $viewData = $this->presenter->present($posts);

        return $this->page->render(
            $this->menuPresenter->render(),
            $this->title,
            $viewData
        );
    }

}

