<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgClasse as ControllerRpgClasse;

class RpgClasse extends Entity
{
    public const TABLE = 'rpgClasse';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;

    public function getController(): ControllerRpgClasse
    {
        $controller = new ControllerRpgClasse;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
}
