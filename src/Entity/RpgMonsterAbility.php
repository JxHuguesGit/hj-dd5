<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterAbility as ControllerRpgMonsterAbility;
use src\Repository\RpgMonster as RepositoryRpgMonster;

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

    public const FIELD_TYPES = [
        Field::TYPEID => 'string',
        Field::MONSTERID => 'intPositive',
        Field::NAME => 'string',
        Field::DESCRIPTION => 'string',
        Field::RANK => 'intPositive',
    ];

    protected string $typeId = '';
    protected int $monsterId = 0;
    protected string $name = '';
    protected string $description = '';
    protected int $rank = 0;

    private ?RpgMonster $monsterCache = null;

    public function stringify(): string
    {
        return sprintf(
            "%s - %s : %s",
            $this->getTypeId(),
            $this->getName(),
            $this->getExcerpt()
        );
    }

    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterAbility
    {
        $controller = new ControllerRpgMonsterAbility();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }
    
    public function getExcerpt(int $max = 80): string
    {
        return mb_strlen($this->description) > $max
            ? mb_substr($this->description, 0, $max) . '...'
            : $this->description;
    }
}
