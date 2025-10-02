<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgWeaponWeaponProficiency extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgJoinWeaponWeaponProficiency',
            [Field::ID, Field::WEAPONID, Field::WPNPROFID, Field::MINRANGE, Field::MAXRANGE, Field::TYPEAMMID, Field::POLYDMG]
        );
    }

}
