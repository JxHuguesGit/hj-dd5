<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\Entity;
use src\Exception\NotFoundException;
use src\Factory\RepositoryFactory;
use src\Repository\RpgPower as RepositoryRpgPower;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Repository\RpgSpeciesPower as RepositoryRpgSpeciesPower;
use src\Page\PageSpecies;
use src\Presenter\MenuPresenter;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Model\PageRegistry;
use src\Presenter\SpeciesPowerPresenter;

class PublicSpecie extends PublicBase
{
    private $specie;

    public function __construct(string $slug, PageSpecies $pageSpecies)
    {
        $repo = RepositoryFactory::create(RepositoryRpgSpecies::class);
        $this->specie = $repo->findBy([Field::SLUG=>$slug]);

        if (!$this->specie) {
            throw new NotFoundException("Espèce introuvable : " . $slug);
        } else {
            $this->specie = $this->specie->first();
        }

        // Construire le PageElement dynamique
        $pageElement = $pageSpecies->getPageElement([
            'slug' => $this->specie->getSlug(),
            'title' => $this->specie->getName(),
            'url' => '/specie-' . $this->specie->getSlug(),
        ]);
        PageRegistry::getInstance()->register($pageElement);
        $this->pageElement = $pageElement;
        
        $this->title = $this->specie->getName();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), 'species'))->render();

        /////////////////////////////////
        // Redirection si l'espèce n'existe pas
        if (!$this->specie) {
            return $this->getRender(Template::NOT_FOUND, [$menuHtml]);
        }
        /////////////////////////////////
        
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());
        
        /////////////////////////////////
        // Récupération des espèces précédente et suivante
        $repo = RepositoryFactory::create(RepositoryRpgSpecies::class);
        $nextSpecies = $repo->findByComplex([
                ['field'=>Field::NAME, 'operand'=>'>', 'value'=>$this->specie->getName()],
                ['field'=>Field::PARENTID, 'operand'=>'=', 'value'=>0],
            ],
            [Field::NAME=>Constant::CST_ASC],
            1
        );
        $prevSpecies = $repo->findByComplex([
                ['field'=>Field::NAME, 'operand'=>'<', 'value'=>$this->specie->getName()],
                ['field'=>Field::PARENTID, 'operand'=>'=', 'value'=>0],
            ],
            [Field::NAME=>Constant::CST_DESC],
            1
        );

        if ($prevSpecies->isEmpty()) {
            $strPrev = '<span></span>';
        } else {
            $prevSpecies = $prevSpecies->first();
            $strPrev = '<a class="btn btn-sm btn-outline-dark" href="/specie-'.$prevSpecies->getSlug().'">&lt; '.$prevSpecies->getName().'</a>';
        }
        if ($nextSpecies->isEmpty()) {
            $strNext = '<span></span>';
        } else {
            $nextSpecies = $nextSpecies->first();
            $strNext = '<a class="btn btn-sm btn-outline-dark" href="/specie-'.$nextSpecies->getSlug().'">'.$nextSpecies->getName().' &gt;</a>';
        }
        /////////////////////////////////

        $repo = RepositoryFactory::create(RepositoryRpgSpeciesPower::class);
        $speciesPowers = $repo->findBy([Field::SPECIESID => $this->specie->getId()], [Field::RANK => Constant::CST_ASC]);
        $strPowers = '';
        if (!$speciesPowers->isEmpty()) {
            $speciesPowerPresenter = new SpeciesPowerPresenter();
            $strPowers = $speciesPowerPresenter->renderList($speciesPowers->map('getPower'), RepositoryFactory::create(RepositoryRpgPower::class));
        }

        /////////////////////////////////
        // Récupération des données liées au WpPost
        $objWpPost = $this->specie->getWpPost();
        $strContent = $objWpPost->post_content;
        /////////////////////////////////

        /////////////////////////////////
        // Définition du template
        $attributes = [
            $this->title,// Titre
            $strContent,
            $strPrev,
            $strNext,
            get_field('type_de_creature', $objWpPost->ID),
            get_field('categorie_de_taille', $objWpPost->ID),
            get_field('vitesse', $objWpPost->ID),
            $strPowers,
        ];
        /////////////////////////////////

        $contentHtml = $this->getRender(TEMPLATE::SPECIE_DETAIL_CARD, $attributes);
        $contentSection = $this->getRender(Template::DETAIL_PAGE, ['', $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
