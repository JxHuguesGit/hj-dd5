<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgSkill as ControllerRpgSkill;
use src\Repository\RpgAbility as RepositoryRpgAbility;
use src\Repository\RpgSubSkill as RepositoryRpgSubSkill;

class RpgSkill extends Entity
{
    public const TABLE = 'rpgSkill';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::ABILITYID,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::ABILITYID => 'intPositive',
    ];
    protected string $name = '';
    protected int $abilityId = 0;

    private ?RpgAbility $abilityCache = null;
    private ?Collection $subSkillsCache = null;
    
    // TODO : à externaliser
    public function getController(): ControllerRpgSkill
    {
        $controller = new ControllerRpgSkill;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->getName();
    }

    public function getAbility(): ?RpgAbility
    {
        return $this->getRelatedEntity('abilityCache', RepositoryRpgAbility::class, $this->abilityId);
    }
    
    public function getSubSkills(): Collection
    {
        if ($this->subSkillsCache === null) {
            $objDao = new RepositoryRpgSubSkill(static::$qb, static::$qe);
            $this->subSkillsCache = $objDao->findBy([Field::SKILLID=>$this->getId()], [Field::NAME=>'ASC']);
        }
        return $this->subSkillsCache;
    }
}
