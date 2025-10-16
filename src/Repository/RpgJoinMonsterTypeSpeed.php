<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgJoinMonsterTypeSpeed extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgJoinMonsterTypeSpeed',
            [Field::ID, Field::MONSTERID, Field::TYPESPEEDID, Field::VALUE, Field::EXTRA]
        );
    }

}
