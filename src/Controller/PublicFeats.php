<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Template;
use src\Factory\RepositoryFactory;
use src\Model\PageRegistry;
use src\Page\PageFeats;
use src\Presenter\MenuPresenter;
use src\Presenter\OrigineCardPresenter;
use src\Repository\RpgFeatType as RepositoryRpgFeatType;

class PublicFeats extends PublicBase
{
    private Collection $subTypes;

    public function __construct()
    {
        $this->title = 'Les Dons';

        $repoSub = RepositoryFactory::create(RepositoryRpgFeatType::class);
        $this->subTypes = $repoSub->findAll();

        $pageElement = (new PageFeats())->getPageElement();
        PageRegistry::getInstance()->register($pageElement);
        $this->pageElement = $pageElement;

        //$repo = RepositoryFactory::create(RepositoryRpgFeat::class);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        // Récupérer le menu depuis le registry
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'feats'))->render();

        $data = [];
        foreach ($this->subTypes as $subType) {
            $data[] = [
                'url' => '/feats-'.$subType->getSlug(),
                'title' => $subType->getName(),
                'description' => '',//$subType->getExcerpt(),
                'icon' => '',//$subType->getIcon(),
                'image' => '',//$subType->getImage(),
            ];
        }

        $cardPresenter = new OrigineCardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}

