<?php
namespace src\Controller;

use src\Constant\Field;
use src\Entity\Hero as EntityHero;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Caste as RepositoryCaste;
use src\Repository\Hero as RepositoryHero;
use src\Utils\Session;

class Caste extends Utilities
{
    public function __construct()
    {
        parent::__construct();

        $this->title = 'Quel titre ?';
    }

    public function getContentPage(): string
    {
        return 'WIP Caste::getContentPage';
    }

    public static function getCreationContentForCaste(): ?Caste
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repositoryCaste = new RepositoryCaste($queryBuilder, $queryExecutor);

        $repositoryHero = new RepositoryHero($queryBuilder, $queryExecutor);
        /** @var EntityHero|null $hero */
        $hero = $repositoryHero->find(Session::fromSession('sessionHeroId'));

        // On a un formulaire en train d'être soumis ?
        // Si oui, il faut le gérer.
        if (Session::isPostSubmitted()) {
            $formName = Session::fromPost('formName');
            if ($formName=='classSelection') {
                $hero->setCasteId(Session::fromPost('classSelectionValue'));
                $repositoryHero->update($hero);
                echo 'WIP getCreationContentForCaste classSelection';
            } else {
                echo 'formName inattendu : ['.$formName.']';
            }
        }
        return new Caste();

        // Quelle classe je suis ?
        $caste = $repositoryCaste->find($hero->getCasteId());
        switch ($caste->getField(Field::CODE)) {
            case 'CLE' :
                $content = 'CLE TODO';
                break;
            case 'FIG' :
                $casteController = new FighterCaste();
                $casteController->setHero($hero);
                $content = $casteController->getContentPage();
                break;
            case 'ROG' :
                $content = 'CLE TODO';
                break;
            case 'WIZ' :
                $content = 'CLE TODO';
                break;
            default :
                // Sonar
                $content  = "[<strong>".$caste->getField(Field::CODE)."</strong>] n'est pas une classe attendue.";
            break;
        }
        return $content;

    }
}
