<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Skill as DomainSkill;
use src\Repository\SkillRepositoryInterface;
use src\Utils\Navigation;

final class SkillReader
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}
    
    public function skillById(int $id): ?DomainSkill
    {
        return $this->skillRepository->find($id);
    }

    public function skillBySlug(string $slug): ?DomainSkill
    {
        $skills = $this->skillRepository->findBy([Field::SLUG=>$slug]);
        return $skills->first() ?? null;
    }
    
    /**
     * @return Collection<DomainSkill>
     */
    public function allSkills(array $orderBy=[]): Collection
    {
        return $this->skillRepository->findAll($orderBy);
    }

    public function getPreviousAndNext(DomainSkill $skill): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($skill) {
                $criteria = new SkillCriteria();
                $criteria->abilityId = $skill->abilityId;
                $operand === '<'
                    ? $criteria->nameLt = $skill->name
                    : $criteria->nameGt = $skill->name
                ;
                return $this->skillRepository->findAllWithCriteria($criteria, [Field::NAME => $order]);
            }
        );
    }
}
