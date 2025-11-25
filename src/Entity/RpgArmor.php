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
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::ARMORTYPID => 'int',
        Field::ARMORCLASS => 'int',
        Field::MALUSSTR => 'int',
        Field::MALUSSTE => 'bool',
        Field::WEIGHT => 'float',
        Field::GOLDPRICE => 'float',
    ];

    protected string $name     = '';
    protected int $armorTypeId = 0;
    protected int $armorClass  = 0;
    protected int $malusStr    = 0;
    protected bool $malusSte   = false;
    protected float $weight    = 0.0;
    protected float $goldPrice = 0.0;
    
    // TODO : Déplacer cette logique dans un EntityManager ou Factory plutôt que dans l'entité.
    public function getController(): ControllerRpgArmor
    {
        $controller = new ControllerRpgArmor();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return sprintf(
            "%s - CA : %d",
            $this->getName(),
            $this->getArmorClass()
        );
    }
}
