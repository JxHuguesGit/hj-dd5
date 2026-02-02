<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Skill as DomainSkill;
use src\Repository\SkillRepositoryInterface;

final class SkillReader
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}
    
    /**
     * @return Collection<DomainSkill>
     */
    public function allSkills(array $orderBy=[]): Collection
    {
        return $this->skillRepository->findAll($orderBy);
    }
    
    public function skillById(int $id): ?DomainSkill
    {
        return $this->skillRepository->find($id);
    }

    public function skillBySlug(string $slug): ?DomainSkill
    {
        $skills = $this->skillRepository->findBy([Field::SLUG=>$slug]);
        return $skills->first() ?? null;
    }

    public function getPreviousAndNext(DomainSkill $skill): array
    {
        // Critère pour l'origine précédente (nom < courant)
        $prevCriteria = new SkillCriteria();
        $prevCriteria->abilityId = $skill->abilityId;
        $prevCriteria->nameLt = $skill->name;

        $prev = $this->skillRepository
            ->findAllWithCriteria($prevCriteria, [Field::NAME => Constant::CST_DESC])
            ->first();

        $nextCriteria = new SkillCriteria();
        $nextCriteria->abilityId = $skill->abilityId;
        $nextCriteria->nameGt = $skill->name;

        $next = $this->skillRepository
            ->findAllWithCriteria($nextCriteria, [Field::NAME => Constant::CST_ASC])
            ->first();

        return [
            'prev' => $prev ?: null,
            'next' => $next ?: null,
        ];
    }
}
