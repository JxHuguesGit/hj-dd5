<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgOrigin as ControllerRpgOrigin;
use src\Enum\AbilityEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
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

    protected string $name;
    protected int $featId;
    protected int $toolId;

    public function getController(): ControllerRpgOrigin
    {
        $controller = new ControllerRpgOrigin();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }
    
    public function getOriginFeat(): ?RpgFeat
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgFeat($queryBuilder, $queryExecutor);
        return $objDao->find($this->featId);
    }
    
    public function getOriginSkills(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgOriginSkill($queryBuilder, $queryExecutor);
        return $objDao->findBy([Field::ORIGINID=>$this->getField(Field::ID)]);
    }
    
    public function getOriginAbilities(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgOriginAbility($queryBuilder, $queryExecutor);
        return $objDao->findBy([Field::ORIGINID=>$this->getField(Field::ID)]);
    }
    
    public function getOriginTool(): RpgTool
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgTool($queryBuilder, $queryExecutor);
        return $objDao->find($this->toolId);
    }
    
}
