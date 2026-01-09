<?php
namespace src\Controller;

use src\Domain\Feat as DomainFeat;
use src\Page\PageFeat;
use src\Presenter\MenuPresenter;
use src\Presenter\FeatDetailPresenter;
use src\Service\Reader\FeatReader;

class PublicFeat extends PublicBase
{
    private ?DomainFeat $feat;

    public function __construct(
        private string $slug,
        private FeatReader $featReader,
        private FeatDetailPresenter $presenter,
        private PageFeat $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->feat = $featReader->getFeatBySlug($this->slug);
        $this->title = $this->feat->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('feats');
        $nav = $this->featReader->getPreviousAndNext($this->feat);
        $viewData = $this->presenter->present(
            $this->feat,
            $nav['prev'],
            $nav['next'],
        );
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
