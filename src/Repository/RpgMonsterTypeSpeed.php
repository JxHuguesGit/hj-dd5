<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterTypeSpeed extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonsterTypeSpeed',
            [Field::ID, Field::MONSTERID, Field::TYPESPEEDID, Field::VALUE, Field::EXTRA]
        );
    }

}
