<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgWeapon extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgWeapon',
            [Field::ID, Field::NAME, Field::DAMAGE, Field::TYPEDMGID, Field::WEIGHT, Field::GOLDPRICE, Field::MARTIAL, Field::MELEE, Field::MSTPROFID]
        );
    }

}
