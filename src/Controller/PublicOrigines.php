<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageOriginList;
use src\Presenter\MenuPresenter;
use src\Presenter\OriginListPresenter;
use src\Service\RpgOriginQueryService;

class PublicOrigines extends PublicBase
{
    private ?Collection $origins = null;

    public function __construct(
        private RpgOriginQueryService $originQueryService,
        private OriginListPresenter $presenter,
        private PageOriginList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origins = $this->originQueryService->getAllOrigins([Field::NAME=>Constant::CST_ASC]);
        $this->title = 'Les Historiques';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('origines');
        $viewData = $this->presenter->present($this->origins);
        $viewData['title'] = $this->getTitle();
        /*

        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'origines'))->render();
        
        if (!$this->origins) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
        
        $tableBuilder = new RpgOriginTableBuilder($this->originService);
        $contentHtml = $tableBuilder->build($this->origins, ['withMarginTop' => false]);
        $contentSection = $this->getRender(
            Template::CATEGORY_PAGE,
            [$this->getTitle(), $contentHtml->display()]
        );

        */
        return $this->page->render($menu, $viewData);
    }
}

