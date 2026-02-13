<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageList;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\{AbilityRepository, FeatRepository, ItemRepository, OriginAbilityRepository, OriginItemRepository, OriginRepository, OriginSkillRepository, SkillRepository, ToolRepository};
use src\Service\Domain\OriginService;
use src\Service\Reader\{AbilityReader, ItemReader, OriginReader, SkillReader};

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
                new OriginSkillRepository($qb, $qe),
                new OriginAbilityRepository($qb, $qe),
                new OriginItemRepository($qb, $qe),
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
