<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgArmor as ControllerRpgArmor;

class RpgArmor extends Entity
{
    public const TABLE = 'rpgArmor';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::ARMORTYPID,
        Field::ARMORCLASS,
        Field::MALUSSTR,
        Field::MALUSSTE,
        Field::WEIGHT,
        Field::GOLDPRICE,
    ];

    protected string $name;
    protected int $armorTypeId;
    protected int $armorClass;
    protected int $malusStr;
    protected bool $malusSte;
    protected float $weight;
    protected float $goldPrice;
    
    public function getController(): ControllerRpgArmor
    {
        $controller = new ControllerRpgArmor();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
}
