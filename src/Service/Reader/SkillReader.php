<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Entity\Skill;
use src\Repository\SkillRepositoryInterface;
use src\Utils\Navigation;

final class SkillReader
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}

    /**
     * @return ?Skill
     */
    public function skillById(int $id): ?Skill
    {
        $criteria = new SkillCriteria();
        $criteria->id = $id;
        return $this->skillRepository
            ->findAllWithRelations($criteria)
            ?->first() ?? null;
    }

    /**
     * @return ?Skill
     */
    public function skillBySlug(string $slug): ?Skill
    {
        $criteria = new SkillCriteria();
        $criteria->slug = $slug;
        return $this->skillRepository
            ->findAllWithRelations($criteria)
            ?->first() ?? null;
    }

    /**
     * @return Collection<Skill>
     */
    public function allSkills(?SkillCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SkillCriteria();
        }
        return $this->skillRepository->findAllWithRelations($criteria);
    }

    /**
     * @return Collection<Skill>
     */
    public function allParentSkills(?SkillCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SkillCriteria();
            $criteria->parentIdIsNull = true;
            $criteria->orderBy = [F::ABILITYID=>C::ASC, F::NAME=>C::ASC];
        }
        return $this->skillRepository->findAllWithRelations($criteria);
    }

    public function getPreviousAndNext(?Skill $skill): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($skill) {
                $criteria = new SkillCriteria();
                $criteria->abilityId = $skill->abilityId;
                if ($operand === '&lt;') {
                    $criteria->nameLt = $skill->name;
                } else {
                    $criteria->nameGt = $skill->name;
                }
                ;
                $criteria->orderBy = [F::NAME => $order];
                return $this->skillRepository->findAllWithRelations($criteria);
            }
        );
    }
}
