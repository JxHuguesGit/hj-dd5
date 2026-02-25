<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\OriginSkillCriteria;
use src\Domain\Entity\OriginSkill;
use src\Repository\OriginSkillRepositoryInterface;

final class OriginSkillReader
{
    public function __construct(
        private OriginSkillRepositoryInterface $repository
    ) {}

    /**
     * @return ?OriginSkill
     */
    public function originSkillById(int $id): ?OriginSkill
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<OriginSkill>
     */
    public function originSkillsBySkill(int $skillId): Collection
    {
        $criteria          = new OriginSkillCriteria();
        $criteria->skillId = $skillId;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<OriginSkill>
     */
    public function originSkillsByOrigin(int $originId): Collection
    {
        $criteria           = new OriginSkillCriteria();
        $criteria->originId = $originId;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
