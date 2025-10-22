<?php
namespace src\Entity;

use src\Controller\RpgMonsterAbility as ControllerRpgMonsterAbility;

class RpgMonsterAbility extends Entity
{

    public function __construct(
        protected int $id,
        protected string $typeId,
        protected int $monsterId,
        protected string $name,
        protected string $description,
        protected int $rank
    ) {

    }

    public function getController(): ControllerRpgMonsterAbility
    {
        $controller = new ControllerRpgMonsterAbility();
        $controller->setField('rpgMonsterAbility', $this);
        return $controller;
    }

}
