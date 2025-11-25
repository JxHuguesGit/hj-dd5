<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;

class MonsterAbilitiesService
{
    private int $monsterId;

    public function __construct(int $monsterId)
    {
        $this->monsterId = $monsterId;
    }

    private function getAbilities(array $params): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repo = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        return $repo->findBy($params, [Field::RANK => 'ASC']);
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
}