<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgArmor extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgArmor',
            [Field::ID, Field::NAME, Field::ARMORTYPID, Field::ARMORCLASS, Field::MALUSSTR, Field::MALUSSTE, Field::WEIGHT, Field::GOLDPRICE]
        );
    }

}
