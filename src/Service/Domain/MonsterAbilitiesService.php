<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Field as F;
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
        $criteria->typeId    = $params[F::TYPEID];
        $criteria->monsterId = $params[F::MONSTERID];
        return $reader->allMonsterAbilities($criteria);
    }

    public function getTraits(): Collection
    {
        return $this->getAbilities([F::TYPEID => 'T', F::MONSTERID => $this->monsterId]);
    }

    public function getActions(): Collection
    {
        return $this->getAbilities([F::TYPEID => 'A', F::MONSTERID => $this->monsterId]);
    }

    public function getBonusActions(): Collection
    {
        return $this->getAbilities([F::TYPEID => 'B', F::MONSTERID => $this->monsterId]);
    }

    public function getReactions(): Collection
    {
        return $this->getAbilities([F::TYPEID => 'R', F::MONSTERID => $this->monsterId]);
    }

    public function getLegendaryActions(): Collection
    {
        return $this->getAbilities([F::TYPEID => 'L', F::MONSTERID => $this->monsterId]);
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
