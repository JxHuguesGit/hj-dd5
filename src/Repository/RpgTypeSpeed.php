<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgTypeSpeed extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgTypeSpeed',
            [Field::ID, Field::NAME, Field::UKTAG, Field::FRTAG]
        );
    }

}
