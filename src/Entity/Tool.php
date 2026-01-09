<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\Tool as ControllerTool;
use src\Repository\Tool as RepositoryTool;

class Tool extends Entity
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
    public function getController(): ControllerTool
    {
        $controller = new ControllerTool();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->parentId > 0
            ? $this->getParent()->getName() . ' → ' . $this->getName()
            : $this->getName();
    }

    public function getParent(): ?Tool
    {
        return $this->parentId > 0
            ? $this->getRelatedEntity('toolCache', RepositoryTool::class, $this->parentId)
            : null;
    }
}
