<?php
namespace src\Entity;

use src\Controller\RpgArmor as ControllerRpgArmor;

class RpgArmor extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $armorTypeId,
        protected int $armorClass,
        protected int $malusStr,
        protected bool $malusSte,
        protected float $weight,
        protected float $goldPrice
    ) {

    }

    public function getController(): ControllerRpgArmor
    {
        $controller = new ControllerRpgArmor();
        $controller->setField('rpgArmor', $this);
        return $controller;
    }
}
