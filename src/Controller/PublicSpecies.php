<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Factory\RepositoryFactory;
use src\Model\PageRegistry;
use src\Model\PageElement;
use src\Presenter\MenuPresenter;
use src\Presenter\SpeciesCardPresenter;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;

class PublicSpecies extends PublicBase
{
    private array $species = [];

    public function __construct()
    {
        $this->title = 'Les Espèces';
        // Ici, new Repo
        $repo = RepositoryFactory::create(RepositoryRpgSpecies::class);
        $species = $repo->findBy([Field::PARENTID=>0], [Field::NAME=>Constant::CST_ASC]);

        $this->species = [];
        foreach ($species as $specie) {
            $this->species[] = [
                'url' => '/specie-'.$specie->getSlug(),
                'title' => $specie->getName(),
                'description' => '',//$specie->getExcerpt(),
                'icon' => '',//$specie->getIcon(),
                'image' => '',//$specie->getImage(),
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
        $menuHtml = (new MenuPresenter($registry->all(), 'species'))->render();
        $cardPresenter = new SpeciesCardPresenter($this->species);
        $contentHtml = $cardPresenter->render();
        
        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}

