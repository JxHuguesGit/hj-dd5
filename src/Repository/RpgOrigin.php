<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgOrigin extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgOrigin',
            [Field::ID, Field::NAME]
        );
    }

}
