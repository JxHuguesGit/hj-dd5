<?php
namespace src\Repository;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgHeros extends Repository
{
    public function __construct(
        protected QueryBuilder $builder,
        protected QueryExecutor $executor
    ) {
        parent::__construct(
            $builder,
            $executor,
            'rpgHeros',
            [Field::ID, Field::NAME, Field::ORIGINID, Field::SPECIESID, Field::WPUSERID, Field::CREATESTEP, Field::LASTUPDATE]
        );
    }

}
