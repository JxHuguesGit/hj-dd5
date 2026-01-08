<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Factory\RepositoryFactory;
use src\Presenter\MenuPresenter;
use src\Model\PageRegistry;
use src\Page\PageFeatsEpic;
use src\Presenter\OrigineCardPresenter;
use src\Repository\RpgFeat as RepositoryRpgFeat;

class PublicFeatEpic extends PublicBase
{
    private $feats = [];

    public function __construct()
    {
        $repo = RepositoryFactory::create(RepositoryRpgFeat::class);
        $this->feats = $repo->findBy(['featTypeId' => 4], [Field::NAME => Constant::CST_ASC]);

        $pageElement = (new PageFeatsEpic())->getPageElement();
        PageRegistry::getInstance()->register($pageElement);
        $this->pageElement = $pageElement;

        $this->title = "Faveurs épiques";
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'feats'))->render();
        
        if (!$this->feats) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
        
        $data = [];
        foreach ($this->feats as $feat) {
            $data[] = [
                'url' => '/feat-'.$feat->getSlug(),
                'title' => $feat->name,
                'description' => '',//$feat->getExcerpt(),
                'icon' => '',//$feat->getIcon(),
                'image' => '',//$feat->getImage(),
            ];
        }

        $cardPresenter = new OrigineCardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
