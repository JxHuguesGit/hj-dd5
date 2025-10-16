<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterResistance extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgMonsterResistance',
            [Field::ID, Field::MONSTERID, Field::TYPEDMGID, Field::TYPERESID]
        );
    }

}
