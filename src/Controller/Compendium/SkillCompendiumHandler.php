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
use src\Repository\SkillRepository;
use src\Repository\SubSkillRepository;
use src\Service\Domain\SkillService;
use src\Service\Reader\SkillReader;

class SkillCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $subRepository = new SubSkillRepository(new QueryBuilder(), new QueryExecutor());
        $repository = new SkillRepository(new QueryBuilder(), new QueryExecutor());
        $reader = new SkillReader($repository);

        $skills = $reader->allSkills([
            Field::ABILITYID => Constant::CST_ASC,
            Field::NAME      => Constant::CST_ASC
        ]);

        $presenter = new SkillListPresenter(
            new SkillService($subRepository)
        );
        $presentContent = $presenter->present($skills);

        $page = new PageList(
            new TemplateRenderer(),
            new SkillTableBuilder()
        );
        return $page->renderAdmin('', $presentContent);
    }
}
