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
        
        
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'feats'))->render();

        /////////////////////////////////
        // Redirection si le don n'existe pas
        if (!$this->feat) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
        /////////////////////////////////
        
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());
        
        $breadcrumb = (new BreadcrumbPresenter(new PageElement(['slug'=>'feats-origin', 'title'=>'Dons d\'origines', 'url'=>'/feats-origin'])))->render();

        /////////////////////////////////
        // Récupération des dons précédent et suivants
        $repo = RepositoryFactory::create(RepositoryRpgFeat::class);
        $nextFeats = $repo->findByComplex([
                ['field'=>Field::NAME, 'operand'=>'>', 'value'=>$this->feat->getName()],
                ['field'=>Field::FEATTYPEID, 'operand'=>'=', 'value'=>$this->feat->getFeatTypeId()],
            ],
            [Field::NAME=>Constant::CST_ASC]
        );
        $prevFeats = $repo->findByComplex([
                ['field'=>Field::NAME, 'operand'=>'<', 'value'=>$this->feat->getName()],
                ['field'=>Field::FEATTYPEID, 'operand'=>'=', 'value'=>$this->feat->getFeatTypeId()],
            ],
            [Field::NAME=>Constant::CST_DESC]
        );

        if ($prevFeats->isEmpty()) {
            $strPrev = '<span></span>';
        } else {
            $prevFeats->rewind();
            $prevFeat = $prevFeats->current();
            $wpPost = $prevFeat->getWpPost();
            if (!$wpPost) {
                $prevFeats->next();
                $prevFeat = $prevFeats->current();
            }
            $strPrev = '<a class="btn btn-sm btn-outline-dark" href="/feat-'.$prevFeat->getSlug().'">&lt; '.$prevFeat->getName().'</a>';
        }
        if ($nextFeats->isEmpty()) {
            $strNext = '<span></span>';
        } else {
            $nextFeats->rewind();
            $nextFeat = $nextFeats->current();
            $wpPost = $nextFeat->getWpPost();
            if (!$wpPost) {
                $nextFeats->next();
                $nextFeat = $nextFeats->current();
            }
            $strNext = '<a class="btn btn-sm btn-outline-dark" href="/feat-'.$nextFeat->getSlug().'">'.$nextFeat->getName().' &gt;</a>';
        }
        /////////////////////////////////

        /////////////////////////////////
        // Récupération des données liées au WpPost
        $objWpPost = $this->feat->getWpPost();
        $strContent = $objWpPost->post_content;
        $strContent = preg_replace('/<p>|<\/p>/', '', $strContent);
        /////////////////////////////////

        switch ($this->feat->getFeatTypeId()) {
            case 1:
                $featType = 'Don d\'origines';
                break;
            case 2:
                $featType = 'Don général (prérequis : niveau 4 ou supérieur';
                $strPreRequis = get_field('prerequis', $objWpPost->ID);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            case 3:
                $featType = 'Don de Style de combat (prérequis : aptitude Style de combat)';
                break;
            case 4:
                $featType = 'Don de faveur épique (prérequis : niveau 19 ou supérieur';
                $strPreRequis = get_field('prerequis', $objWpPost->ID);
                if ($strPreRequis) {
                    $featType .= ', ' . $strPreRequis;
                }
                $featType .= ')';
                break;
            default:
                $featType = 'Don non identifié';
                break;
        }

        $attributes = [
            $breadcrumb,
            $this->title,
            $strContent,
            $strPrev,
            $strNext,
            $featType,
            '', '', '', '', '', '',
        ];
        $contentHtml = $this->getRender(TEMPLATE::FEAT_DETAIL_CARD, $attributes);
        $contentSection = $this->getRender(Template::DETAIL_PAGE, ['', $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
