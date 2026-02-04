<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\OriginRepository;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\SkillRepository;
use src\Repository\SubSkillRepository;
use src\Service\Domain\SkillService;
use src\Service\Reader\OriginReader;
use src\Service\Reader\SkillReader;

class SkillCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $originSkillRepository = new RepositoryOriginSkill($qb, $qe);
        $subRepository = new SubSkillRepository($qb, $qe);
        $repository = new SkillRepository($qb, $qe);
        $reader = new SkillReader($repository);
        $originRepository = new OriginRepository($qb, $qe);
        $originReader = new OriginReader($originRepository);

        $skills = $reader->allSkills([
            Field::ABILITYID => Constant::CST_ASC,
            Field::NAME      => Constant::CST_ASC
        ]);

        $presenter = new SkillListPresenter(
            new SkillService(
                $originSkillRepository,
                $subRepository,
                $originReader
                )
        );
        $presentContent = $presenter->present($skills);

        $page = new PageList(
            new TemplateRenderer(),
            new SkillTableBuilder()
        );
        return $page->renderAdmin('', $presentContent);
    }
}
