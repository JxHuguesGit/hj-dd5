<?php
namespace src\Controller\Compendium;

use src\Domain\Criteria\ToolCriteria;
use src\Page\PageList;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Presenter\TableBuilder\ToolTableBuilder;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Repository\OriginRepository;
use src\Repository\ToolRepository;
use src\Service\Reader\OriginReader;

final class ToolCompendiumHandler implements CompendiumHandlerInterface
{
    public function render(): string
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $repository = new ToolRepository($qb, $qe);

        $tools = $repository->findAllWithRelations(new ToolCriteria());

        $presenter = new ToolListPresenter(
            new OriginReader(
                new OriginRepository($qb, $qe)
            )
        );
        $content   = $presenter->present($tools);

        $page = new PageList(
            new TemplateRenderer(),
            new ToolTableBuilder()
        );

        return $page->renderAdmin('', $content);
    }
}
