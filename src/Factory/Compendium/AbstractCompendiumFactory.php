<?php
namespace src\Factory\Compendium;

use src\Page\PageList;
use src\Query\{QueryBuilder, QueryExecutor};
use src\Renderer\TemplateRenderer;

abstract class AbstractCompendiumFactory
{
    public function __construct(
        protected QueryBuilder $qb,
        protected QueryExecutor $qe,
        protected TemplateRenderer $renderer
    ) {}

    protected function repo(string $class): object
    {
        return new $class($this->qb, $this->qe);
    }

    protected function reader(string $readerClass, string $repoClass): object
    {
        return new $readerClass($this->repo($repoClass));
    }

    protected function page(object $tableBuilder): PageList
    {
        return new PageList($this->renderer, $tableBuilder);
    }

    protected function writer(string $readerClass, string $repoClass): object
    {
        return new $readerClass($this->repo($repoClass));
    }
}
