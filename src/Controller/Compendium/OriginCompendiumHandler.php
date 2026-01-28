<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\AbilityRepository;
use src\Repository\FeatRepository;
use src\Repository\ItemRepository;
use src\Repository\OriginAbility;
use src\Repository\OriginItem;
use src\Repository\OriginRepository;
use src\Repository\OriginSkill;
use src\Repository\SkillRepository;
use src\Repository\ToolRepository;
use src\Service\Domain\OriginService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\ItemReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\SkillReader;

class OriginCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new OriginRepository($qb, $qe);
        $reader = new OriginReader($repository);

        $origins = $reader->allOrigins([
            Field::NAME      => Constant::CST_ASC
        ]);

        $presenter = new OriginListPresenter(
            new OriginService(
                new FeatRepository($qb, $qe),
                new ToolRepository($qb, $qe),
                new OriginSkill($qb, $qe),
                new OriginAbility($qb, $qe),
                new OriginItem($qb, $qe),
                new SkillReader(
                    new SkillRepository($qb, $qe)
                ),
                new AbilityReader(
                    new AbilityRepository($qb, $qe)
                ),
                new ItemReader(
                    new ItemRepository($qb, $qe)
                )
            )
        );
        $presentContent = $presenter->present($origins);

        $page = new PageList(
            new TemplateRenderer(),
            new OriginTableBuilder()
        );
        return $page->renderAdmin('', $presentContent);
    }
}
