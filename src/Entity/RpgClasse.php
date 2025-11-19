<?php
namespace src\Entity;

use src\Controller\RpgClasse as ControllerRpgClasse;

class RpgClasse extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

    public function getController(): ControllerRpgClasse
    {
        $controller = new ControllerRpgClasse;
        $controller->setField('rpgClasse', $this);
        return $controller;
    }
}
