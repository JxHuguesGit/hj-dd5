<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgTool as ControllerRpgTool;

class RpgTool extends Entity
{
    public const TABLE = 'rpgTool';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::PARENTID,
    ];

    protected string $name;
    protected int $parentId;

    public function getController(): ControllerRpgTool
    {
        $controller = new ControllerRpgTool();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
}
