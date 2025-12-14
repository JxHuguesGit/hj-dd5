<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Factory\RepositoryFactory;
use src\Model\PageRegistry;
use src\Presenter\MenuPresenter;
use src\Presenter\OrigineCardPresenter;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;

class PublicOrigines extends PublicBase
{
    private array $origines = [];

    public function __construct()
    {
        $this->title = 'Les Origines';

        // Ici, new Repo
        $repo = RepositoryFactory::create(RepositoryRpgOrigin::class);
        $origins = $repo->findAll([Field::NAME=>Constant::CST_ASC]);

        $this->origines = [];
        foreach ($origins as $origin) {
            $this->origines[] = [
                'url' => '/origine-'.$origin->getSlug(),
                'title' => $origin->getName(),
                'description' => '',//$origin->getExcerpt(),
                'icon' => '',//$origin->getIcon(),
                'image' => '',//$origin->getImage(),
            ];
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        // Récupérer le menu depuis le registry
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'origines'))->render();
        $cardPresenter = new OrigineCardPresenter($this->origines);
        $contentHtml = $cardPresenter->render();
        
        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}

