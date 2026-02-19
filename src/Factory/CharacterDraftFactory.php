<?php
namespace src\Factory;

use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;

final class CharacterDraftFactory
{
    public function __construct(
        private QueryBuilder $qb,
        private QueryExecutor $qe,
        private TemplateRenderer $renderer
    ) {}

}
