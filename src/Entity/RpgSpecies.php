<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgSpecies as ControllerRpgSpecies;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;

class RpgSpecies extends Entity
{
    public const TABLE = 'rpgSpecies';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::PARENTID,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::PARENTID => 'intPositive',
    ];
    
    protected string $name = '';
    protected int $parentId = 0;

    private ?RpgSpecies $speciesCache = null;
    
    // TODO : à externaliser
    public function getController(): ControllerRpgSpecies
    {
        $controller = new ControllerRpgSpecies();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->getFullName();
    }

    public function getFullName(): string
    {
        if ($this->parentId==0) {
            return $this->name;
        } else {
            return $this->getSpecies()->getFullName().' ('.$this->name.')';
        }
    }

    public function getSpecies(): ?RpgSpecies
    {
        return $this->getRelatedEntity('speciesCache', RepositoryRpgSpecies::class, $this->parentId);
    }
}
