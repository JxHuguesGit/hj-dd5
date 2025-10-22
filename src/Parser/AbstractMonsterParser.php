<?php
namespace src\Parser;

use src\Entity\RpgMonster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

abstract class AbstractMonsterParser
{
    protected const FEET_TO_METERS = 0.3;

    protected QueryBuilder $queryBuilder;
    protected QueryExecutor $queryExecutor;
    protected RpgMonster $rpgMonster;
    protected \DOMDocument $dom;

    public function __construct(
        QueryBuilder $queryBuilder,
        QueryExecutor $queryExecutor,
        RpgMonster $rpgMonster,
        \DOMDocument $dom
    ) {
        $this->queryBuilder  = $queryBuilder;
        $this->queryExecutor = $queryExecutor;
        $this->rpgMonster    = $rpgMonster;
        $this->dom           = $dom;
    }

    /**
     * Factory method commune : permet un appel statique unifié
     */
    public static function parse(RpgMonster &$rpgMonster, \DOMDocument $dom): bool
    {
        // new static() → respecte le late static binding
        $parser = new static(new QueryBuilder(), new QueryExecutor(), $rpgMonster, $dom);
        return $parser->doParse();
    }

    /**
     * Méthode à implémenter dans les classes filles
     */
    abstract protected function doParse(): bool;
}

