<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Field;
use src\Domain\Criteria\MonsterAbilityCriteria;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\MonsterAbilityRepository;
use src\Repository\MonsterConditionRepository;
use src\Repository\MonsterResistanceRepository;
use src\Repository\MonsterSkillRepository;
use src\Service\Reader\MonsterAbilityReader;
use src\Service\Reader\MonsterConditionReader;
use src\Service\Reader\MonsterResistanceReader;
use src\Service\Reader\MonsterSkillReader;

class MonsterAbilitiesService
{
    private int $monsterId;

    public function __construct(int $monsterId)
    {
        $this->monsterId = $monsterId;
    }

    private function getAbilities(array $params): Collection
    {
        $reader = new MonsterAbilityReader(
            new MonsterAbilityRepository(
                new QueryBuilder(),
                new QueryExecutor()
            )
        );
        $criteria            = new MonsterAbilityCriteria();
        $criteria->typeId    = $params[Field::TYPEID];
        $criteria->monsterId = $params[Field::MONSTERID];
        return $reader->allMonsterAbilities($criteria);
    }

    public function getTraits(): Collection
    {
        return $this->getAbilities([Field::TYPEID => 'T', Field::MONSTERID => $this->monsterId]);
    }

    public function getActions(): Collection
    {
        return $this->getAbilities([Field::TYPEID => 'A', Field::MONSTERID => $this->monsterId]);
    }

    public function getBonusActions(): Collection
    {
        return $this->getAbilities([Field::TYPEID => 'B', Field::MONSTERID => $this->monsterId]);
    }

    public function getReactions(): Collection
    {
        return $this->getAbilities([Field::TYPEID => 'R', Field::MONSTERID => $this->monsterId]);
    }

    public function getLegendaryActions(): Collection
    {
        return $this->getAbilities([Field::TYPEID => 'L', Field::MONSTERID => $this->monsterId]);
    }

    public function getSkills(): Collection
    {
        $reader = new MonsterSkillReader(
            new MonsterSkillRepository(
                new QueryBuilder(),
                new QueryExecutor()
            )
        );
        return $reader->monsterSkillsByMonster($this->monsterId);
    }

    public function getConditions(): Collection
    {
        $reader = new MonsterConditionReader(
            new MonsterConditionRepository(
                new QueryBuilder(),
                new QueryExecutor()
            )
        );
        return $reader->monsterConditionsByMonsterId($this->monsterId);
    }

    public function getResistances(): Collection
    {
        $reader = new MonsterResistanceReader(
            new MonsterResistanceRepository(
                new QueryBuilder(),
                new QueryExecutor()
            )
        );
        return $reader->monsterResistancesByMonsterId($this->monsterId);
    }
}
