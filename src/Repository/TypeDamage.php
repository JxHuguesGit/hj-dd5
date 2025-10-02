<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class TypeDamage extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor,
        protected Collection $collection
    ) {
        parent::__construct(
            $builder,
            $executor,
            $collection,
            'mmorpgTypeDamage',
            [Field::ID, Field::CODE]
        );
    }

}
