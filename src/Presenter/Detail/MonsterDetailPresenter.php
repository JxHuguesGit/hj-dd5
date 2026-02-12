<?php
namespace src\Presenter\Detail;

use src\Domain\Entity\Monster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\SousTypeMonsterRepository;
use src\Repository\TypeMonsterRepository;
use src\Service\Formatter\MonsterFormatter;
use src\Service\Reader\SousTypeMonsterReader;
use src\Service\Reader\TypeMonsterReader;

class MonsterDetailPresenter
{
    public function __construct(
        private Monster $monster
    ) {}

    public function present(): array
    {
        $qb = new QueryBuilder();
        $qe = new QueryExecutor();
        $formatter = new MonsterFormatter(
            new TypeMonsterReader(new TypeMonsterRepository($qb, $qe)),
            new SousTypeMonsterReader(new SousTypeMonsterRepository($qb, $qe)),
        );

        return [
            $formatter->formatName($this->monster->name, $this->monster->frName),
            '', '', '', '', '',
            $formatter->formatScore($this->monster, 'str'),
            $formatter->formatScore($this->monster, 'dex'),
            $formatter->formatScore($this->monster, 'con'),
            $formatter->formatScore($this->monster, 'int'),
            $formatter->formatScore($this->monster, 'wis'),
            $formatter->formatScore($this->monster, 'cha'),
            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
            '', '', '', '',
        ];
    }
}
