<?php
namespace src\Controller;

use src\Domain\RpgFeat;


use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\Entity;
use src\Entity\RpgFeat as EntityRpgFeat;
use src\Exception\NotFoundException;
use src\Factory\RepositoryFactory;
use src\Model\PageElement;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Presenter\BreadcrumbPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\FeatDetailPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Service\RpgFeatService;
use src\Service\RpgFeatQueryService;

class PublicFeat extends PublicBase
{
    private ?RpgFeat $feat;

    public function __construct(
        private string $slug,
        private RpgFeatService $featService,
        private RpgFeatQueryService $featQueryService,
        private FeatDetailPresenter $presenter,
        private PageFeat $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->feat = $featQueryService->getFeatBySlug($this->slug);
        $this->title = $this->feat->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('feats');
        $nav = $this->featQueryService->getPreviousAndNext($this->feat);
        $viewData = $this->presenter->present(
            $this->feat,
            $nav['prev'],
            $nav['next'],
        );
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
