<?php
namespace src\Controller;

use src\Factory\CharacterFactory;

class AdminCharacterPage extends AdminPage
{
    public function __construct(
        private array $uri,
        private CharacterFactory $characterFactory
    ) {
        parent::__construct($this->uri);
    }

    public function getAdminContentPage(string $content=''): string
    {
        return 'wip';
    }
}
/*
    public function oldgetAdminContentPage(string $content=''): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());

        // Dépendances
        $deps = $this->buildDeps($queryBuilder, $queryExecutor);

        // Suppression éventuelle du héros.
        if (isset($this->arrParams['action']) && $this->arrParams['action'] === 'delete') {
            $heroId = $this->arrParams['id'];
            $wpUserId = Session::getWpUser()->ID;

            $heros = $deps['heroRepo']->findBy([Field::ID=>$heroId, Field::WPUSERID=>$wpUserId], [], -1, true);
            $hero = $heros->first();
            if ($hero instanceof RpgHeros) {
                $hero->delete();
                $this->arrParams['id'] = 0;
            }
        }

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
            'toolRepo'        => new RepositoryTool($qb, $qe),
        ];
    }
}
*/
