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
        Field::SKILLS,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::SKILLS => 'intPositive',
    ];

    protected string $name = '';
    protected int $skills  = 0;

    // TODO : A externaliser
    public function getController(): ControllerRpgClasse
    {
        $controller = new ControllerRpgClasse;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return sprintf(
            "%s (%d)",
            $this->getName(),
            $this->getSkills()
        );
    }
}
