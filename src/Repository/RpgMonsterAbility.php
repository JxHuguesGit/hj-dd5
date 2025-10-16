<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterAbility extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonsterAbility',
            [Field::ID, Field::TYPEID, Field::NAME, Field::DESCRIPTION, Field::MONSTERID]
        );
    }
}
