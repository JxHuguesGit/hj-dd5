<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterAbility as ControllerRpgMonsterAbility;

class RpgMonsterAbility extends Entity
{
    public const TABLE = 'rpgMonsterAbility';
    public const FIELDS = [
        Field::ID,
        Field::TYPEID,
        Field::MONSTERID,
        Field::NAME,
        Field::DESCRIPTION,
        Field::RANK,
    ];

    protected string $typeId;
    protected int $monsterId;
    protected string $name;
    protected string $description;
    protected int $rank;

    public function getController(): ControllerRpgMonsterAbility
    {
        $controller = new ControllerRpgMonsterAbility();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

}
