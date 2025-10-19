<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterSkill extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonsterSkill',
            [Field::ID, Field::MONSTERID, Field::SKILLID, Field::VALUE]
        );
    }

}