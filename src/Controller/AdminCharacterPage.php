<?php
namespace src\Controller;

use src\CharacterCreation\CharacterCreationFlow;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHeros;
use src\Entity\RpgHerosClasse as EntityRpgHerosClasse;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgClasse as RepositoryRpgClasse;
use src\Repository\RpgClasseSkill as RepositoryRpgClasseSkill;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgHerosClasse as RepositoryRpgHerosClasse;
use src\Repository\RpgHerosFeat as RepositoryRpgHerosFeat;
use src\Repository\RpgHerosSkill as RepositoryRpgHerosSkill;
use src\Repository\RpgOrigin as RepositoryRpgOrigin;
use src\Repository\RpgOriginSkill as RepositoryRpgOriginSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Repository\RpgTool as RepositoryRpgTool;
use src\Utils\Session;

class AdminCharacterPage extends AdminPage
{

    public function getAdminContentPage(string $content=''): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        // Dépendances
        $deps = $this->buildDeps($queryBuilder, $queryExecutor);

        // Initialisation du Heros
        $rpgHero = $this->loadHero($deps['heroRepo']);
        
        // Flow de création
        $flow = new CharacterCreationFlow(
            $rpgHero,
            // Injection des dépendances nécessaires
            $deps,
            fn($tpl, $vars) => $this->getRender($tpl, $vars)
        );
        $stepData = $flow->handle();

        // Retourne le rendu pour le template
        $page = $this->getRender($stepData['template'], $stepData['variables']);
        return parent::getAdminContentPage($this->getRender(Template::ADMINCOMPENDIUM, [$page, '']));
    }

    private function loadHero(RepositoryRpgHeros $heroRepo): RpgHeros
    {
        $id = Session::fromPost('characterId', $this->arrParams['id']??0);
        if ($id==0) {
            return RpgHeros::init();
        }

        return $heroRepo->find($id) ?? RpgHeros::init();
    }

    private function buildDeps(QueryBuilder $qb, QueryExecutor $qe): array
    {
        return [
            'classRepo'       => new RepositoryRpgClasse($qb, $qe),
            'classSkillRepo'  => new RepositoryRpgClasseSkill($qb, $qe),
            'featRepo'        => new RepositoryRpgFeat($qb, $qe),
            'heroRepo'        => new RepositoryRpgHeros($qb, $qe),
            'heroClassRepo'   => new RepositoryRpgHerosClasse($qb, $qe),
            'heroFeatRepo'    => new RepositoryRpgHerosFeat($qb, $qe),
            'heroSkillRepo'   => new RepositoryRpgHerosSkill($qb, $qe),
            'originRepo'      => new RepositoryRpgOrigin($qb, $qe),
            'originSkillRepo' => new RepositoryRpgOriginSkill($qb, $qe),
            'skillRepo'       => new RepositoryRpgSkill($qb, $qe),
            'speciesRepo'     => new RepositoryRpgSpecies($qb, $qe),
            'toolRepo'        => new RepositoryRpgTool($qb, $qe),
        ];
    }


    private function dealWithHerosForm(string $herosForm): void
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDaoHeros = new RepositoryRpgHeros($queryBuilder, $queryExecutor);

            $objHero = $objDaoHeros->find(Session::fromPost('characterId'));
            switch ($herosForm) {
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
