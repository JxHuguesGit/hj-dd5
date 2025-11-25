<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgOrigin as ControllerRpgOrigin;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Repository\RpgOriginAbility as RepositoryRpgOriginAbility;
use src\Repository\RpgOriginSkill as RepositoryRpgOriginSkill;
use src\Repository\RpgTool as RepositoryRpgTool;

class RpgOrigin extends Entity
{
    public const TABLE = 'rpgOrigin';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::FEATID,
        Field::TOOLID,
    ];
    
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::FEATID => 'intPositive',
        Field::TOOLID => 'intPositive',
    ];

    protected string $name = '';
    protected int $featId = 0;
    protected int $toolId = 0;

    private ?RpgFeat $featCache = null;
    private ?RpgTool $toolCache = null;
    private ?Collection $skillsCache = null;
    private ?Collection $abilitiesCache = null;

    // TODO : à externaliser
    public function getController(): ControllerRpgOrigin
    {
        $controller = new ControllerRpgOrigin();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return $this->getName();
    }

    public function getOriginFeat(): ?RpgFeat
    {
        return $this->getRelatedEntity('featCache', RepositoryRpgFeat::class, $this->featId);
    }
    
    public function getOriginTool(): ?RpgTool
    {
        return $this->getRelatedEntity('toolCache', RepositoryRpgTool::class, $this->toolId);
    }
    
    public function getOriginSkills(): Collection
    {
        if ($this->skillsCache === null) {
            $objDao = new RepositoryRpgOriginSkill(static::$qb, static::$qe);
            $this->skillsCache = $objDao->findBy([Field::ORIGINID=>$this->getId()]);
        }
        return $this->skillsCache;
    }
     
    public function getOriginAbilities(): Collection
    {
        if ($this->abilitiesCache === null) {
            $objDao = new RepositoryRpgOriginAbility(static::$qb, static::$qe);
            $this->abilitiesCache = $objDao->findBy([Field::ORIGINID=>$this->getId()]);
        }
        return $this->abilitiesCache;
    }
}
