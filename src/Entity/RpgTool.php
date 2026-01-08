<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgTool as ControllerRpgTool;
use src\Repository\RpgTool as RepositoryRpgTool;

class RpgTool extends Entity
{
    public const TABLE = 'rpgTool';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
        Field::PARENTID,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::SLUG => 'string',
        Field::PARENTID => 'intPositive',
    ];
        
    protected string $name = '';
    protected string $slug = '';
    protected int $parentId = 0;

    // TODO : à externaliser
    public function getController(): ControllerRpgTool
    {
        $controller = new ControllerRpgTool();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->parentId > 0
            ? $this->getParent()->getName() . ' → ' . $this->getName()
            : $this->getName();
    }

    public function getParent(): ?RpgTool
    {
        return $this->parentId > 0
            ? $this->getRelatedEntity('toolCache', RepositoryRpgTool::class, $this->parentId)
            : null;
    }
}