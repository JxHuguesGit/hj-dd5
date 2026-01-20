<?php
namespace src\Controller\Public;

use src\Domain\Feat as DomainFeat;
use src\Page\PageFeat;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\FeatDetailPresenter;
use src\Service\Page\FeatPageService;
use src\Service\Reader\FeatReader;

class PublicFeat extends PublicBase
{
    private ?DomainFeat $feat;

    public function __construct(
        private string $slug,
        private FeatReader $featReader,
        private FeatPageService $pageService,
        private FeatDetailPresenter $presenter,
        private PageFeat $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->feat = $this->featReader->featBySlug($this->slug);
        $this->title = $this->feat->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('feats');
        $pageView = $this->pageService->build($this->feat);
        $viewData = $this->presenter->present($pageView);
        return $this->page->render($menu, $viewData);
    }
}
