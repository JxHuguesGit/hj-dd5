<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterSkillCriteria;
use src\Domain\Entity\MonsterSkill;
use src\Repository\MonsterSkillRepositoryInterface;

final class MonsterSkillReader
{
    public function __construct(
        private MonsterSkillRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterSkill
     */
    public function monsterSkillById(int $id): ?MonsterSkill
    {
        return $this->repository->find($id);
    }

    public function monsterSkillsByMonster(int $id): Collection
    {
        $criteria            = new MonsterSkillCriteria();
        $criteria->monsterId = $id;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterSkill>
     */
    public function allMonsterSkills(?MonsterSkillCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterSkillCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
