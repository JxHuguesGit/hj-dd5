<?php
namespace src\Controller;

use src\Constant\Field;
use src\Constant\Template;
use src\Entity\MockHero;
use src\Entity\RpgHeros;
use src\Entity\RpgHerosClasse as EntityRpgHerosClasse;
use src\Entity\RpgHerosFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgHerosClasse as RepositoryRpgHerosClasse;
use src\Repository\RpgHerosFeat as RepositoryRpgHerosFeat;
use src\Utils\Session;

class AdminCharacterPage extends AdminPage
{

    public function getAdminContentPage(string $content=''): string
    {
        $herosForm = Session::fromPost('herosForm');
        if ($herosForm!='') {
            $this->dealWithHerosForm($herosForm);
        }

        $id = Session::fromPost('characterId', $this->arrParams['id']??0);
        if ($id==0) {
            $rpgHero = RpgHeros::init();
        } else {
            $queryBuilder  = new QueryBuilder();
            $queryExecutor = new QueryExecutor();
            $objDaoHeros = new RepositoryRpgHeros($queryBuilder, $queryExecutor);
            $rpgHero = $objDaoHeros->find($id);
            if ($rpgHero==null) {
                $rpgHero = RpgHeros::init();
            }
        }

        // Faudrait tester qu'on soit bien toujours en phase de création
        $this->arrParams['rpgHero'] = $rpgHero;
        $adminPage = new AdminCharacterCreationPage($this->arrParams);
        return $adminPage->getAdminContentPage();

        // TTTTTT OOOOOO OOOOO  OOOOOO
        //   TT   OO  OO OO  OO OO  OO
        //   TT   OO  OO OO  OO OO  OO
        //   TT   OOOOOO OOOOO  OOOOOO
        //
        // Si on n'est plus en phase de création, il faut afficher la fiche de personnage

        // Ici, on va gérer l'affichage de la feuille de personnage.
        // On va utiliser des personnages Mock.
        /*
        $mockHero = new MockHero();

        $hero = $mockHero->getHero();
        $controller = $hero->getController();
        $attributes = $controller->getNameBlock();
        
        $completeAttributes = array_merge(
            $attributes,
            [
                $controller->getQuickInfoBlock(), // bloc des données chiffrées
                $controller->getSubsectionsBlock(), // bloc des données chiffrées
            ]
        );

        $content .= $this->getRender(Template::ADMINCHARACTER, ['', '', '', '', '', '', '', '', '']); //$completeAttributes
        return parent::getAdminContentPage($content);
        */
    }


    private function dealWithHerosForm(string $herosForm): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoHeros = new RepositoryRpgHeros($queryBuilder, $queryExecutor);

        if (Session::fromPost('characterId')=='') {
            $objHero = RpgHeros::init();
            $objHero->setField(Field::NAME, Session::fromPost('characterName'));
            $objDaoHeros->insert($objHero);
        } else {
            $objHero = $objDaoHeros->find(Session::fromPost('characterId'));
            switch ($herosForm) {
                case 'createHeros' :
                    $objHero->setField(Field::NAME, Session::fromPost('characterName'));
                    $objHero->setField(Field::CREATESTEP, 'origin');
                break;
                case 'selectOrigin' :
                    $objHero->setField(Field::ORIGINID, Session::fromPost('characterOriginId'));
                    $objHero->setField(Field::CREATESTEP, 'species');
                break;
                case 'selectSpecies' :
                    $objHero->setField(Field::SPECIESID, Session::fromPost('characterSpeciesId'));
                    $objHero->setField(Field::CREATESTEP, 'originFeat');
                break;
                case 'selectFeats' :
                    $selectedId = Session::fromPost('characterFeatId');
                    $secondSelId = Session::fromPost('secondFeatId', -1);
                    $extraSelectedId = Session::fromPost('extraCharacterFeatId', 0);
                    $extraSecondSelId = Session::fromPost('extraSecondFeatId', 0);

                    $objDaoHerosFeat = new RepositoryRpgHerosFeat($queryBuilder, $queryExecutor);
                    // On purge les jointures liées au personnage
                    $objs = $objDaoHerosFeat->findBy([Field::HEROSID=>$objHero->getField(Field::ID)]);
                    $objs->rewind();
                    while ($objs->valid()) {
                        $obj = $objs->current();
                        $objDaoHerosFeat->delete($obj);
                        $objs->next();
                    }
                    // On créé les nouvelles jointures.
                    $obj = new RpgHerosFeat(...[0, $objHero->getField(Field::ID), $selectedId, $selectedId==5?$extraSelectedId:0]);
                    $objDaoHerosFeat->insert($obj);
                    if ($secondSelId!=-1) {
                        $obj = new RpgHerosFeat(...[0, $objHero->getField(Field::ID), $secondSelId, $secondSelId==5?$extraSecondSelId:0]);
                        $objDaoHerosFeat->insert($obj);
                    }
                    $objHero->setField(Field::CREATESTEP, 'classe');
                break;
                case 'selectClass' :
                    $selectedId = Session::fromPost('characterClassId');

                    $objDao = new RepositoryRpgHerosClasse($queryBuilder, $queryExecutor);
                    // On purge les jointures liées au personnage
                    $objs = $objDao->findBy([Field::HEROSID=>$objHero->getField(Field::ID)]);
                    $objs->rewind();
                    while ($objs->valid()) {
                        $obj = $objs->current();
                        $objDao->delete($obj);
                        $objs->next();
                    }
                    // On créé les nouvelles jointures.
                    $obj = new EntityRpgHerosClasse(...[0, $objHero->getField(Field::ID), $selectedId, 1]);
                    $objDao->insert($obj);
                    $objHero->setField(Field::CREATESTEP, 'classe');
                break;
                default :
                    // Sonar
                break;
            }
            $objHero->setField(Field::LASTUPDATE, time());
            $objDaoHeros->update($objHero);
        }
    }
}
