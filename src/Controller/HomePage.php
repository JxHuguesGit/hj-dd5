<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Hero as HeroRepository;
use src\Utils\Session;
use WP_User;

class HomePage extends Utilities
{

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Home';
    }

    public function getContentPage(string $msgProcessError=''): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        $currentUser = Session::getWpUser();

        // On va récupérer la liste des personnages créés par ce User
        $repository = new HeroRepository($queryBuilder, $queryExecutor);
        $collection = $repository->findBy([Field::WPUSERID=>$currentUser->ID]);

        // On va présenter un formulaire qui liste ces personnages disponibles
        $strExistingPjs = '';
        $collection->rewind();
        while ($collection->valid()) {
            $hero = $collection->current();
            $strExistingPjs .= $hero->getController()->getHeroSelectionLine();
            $collection->next();
        }
        // Puis on ajoute la possibilité de créer un nouveau personnage.
        // Dans le template

        return $this->getRender(Template::HERO_SELECTION, [$strExistingPjs]);
    }

    public static function getController(): Utilities
    {
        // On commente pour le moment sinon, on n'accède nulle par si on n'est pas identifié.
        //if (!is_user_logged_in()) {
        //    $controller = new self();
        //} else {
            $currentUser = wp_get_current_user();
            if (Session::isPostSubmitted()) {
                if (Session::fromPost(Constant::FORMNAME)=='heroSelection') {
                    $controller = new Hero();
                } elseif (Session::fromPost(Constant::FORMNAME)=='classSelection') {
                    $controller = Caste::getCreationContentForCaste();
                } else {
                    echo 'Formname non couvert ['.Session::fromPost(Constant::FORMNAME).']<br>';
                    var_dump($_POST);
                    $controller = new self();
                }
            } else {
                $action = Session::fromGet('action', '');
                if ($action=='heroLogOut') {
                    Session::unsetSession('sessionHeroId');
                }
                $heroId = Session::fromSession('sessionHeroId');
                $queryBuilder  = new QueryBuilder();
                $queryExecutor = new QueryExecutor();
                $repository = new HeroRepository($queryBuilder, $queryExecutor);
                $entityHero = $repository->find($heroId);
                if ($entityHero!=null) {
                    $controller = new Hero();
                } else {
                    $controller = new self();
                }
            }
        //}

        return $controller;
    }
}
