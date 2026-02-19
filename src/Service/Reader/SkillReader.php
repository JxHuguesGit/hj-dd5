<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
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
        return $this->skillRepository->find($id);
    }

    /**
     * @return ?Skill
     */
    public function skillBySlug(string $slug): ?Skill
    {
        $criteria = new SkillCriteria();
        $criteria->slug = $slug;
        return $this->skillRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Skill>
     */
    public function allSkills(?SkillCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new SkillCriteria();
            $criteria->orderBy = [Field::ABILITYID=>Constant::CST_ASC, Field::NAME=>Constant::CST_ASC];
        }
        return $this->skillRepository->findAllWithCriteria($criteria);
    }

    public function getPreviousAndNext(Skill $skill): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($skill) {
                $criteria = new SkillCriteria();
                $criteria->abilityId = $skill->abilityId;
                $operand === '&lt;'
                    ? $criteria->nameLt = $skill->name
                    : $criteria->nameGt = $skill->name
                ;
                $criteria->orderBy = [Field::NAME => $order];
                return $this->skillRepository->findAllWithCriteria($criteria);
            }
        );
    }
}
