<?php
namespace src\Entity;

use src\Controller\RpgOrigin as ControllerRpgOrigin;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgOrigin extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

    public function getController(): ControllerRpgOrigin
    {
        $controller = new ControllerRpgOrigin;
        $controller->setField('rpgOrigin', $this);
        return $controller;
    }
    
}
