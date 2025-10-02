<?php
namespace src\Entity;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgTypeAmmunition extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

}