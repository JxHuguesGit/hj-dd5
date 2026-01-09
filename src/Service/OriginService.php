<?php
namespace src\Service;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\Origin as DomainOrigin;
use src\Domain\Skill as DomainSkill;
use src\Repository\Feat as RepositoryFeat;
use src\Repository\OriginAbility as RepositoryOriginAbility;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\Tool as RepositoryTool;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\SkillReader;

final class OriginService
{
    /** @var array<int, RpgAbility> */
    private array $abilityCache = [];
    /** @var array<int, DomainSkill> */
    private array $skillCache = [];
    
    public function __construct(
        private RepositoryFeat $featRepository,
        private RepositoryTool $toolRepository,
        private RepositoryOriginSkill $originSkillRepository,
        private RepositoryOriginAbility $originAbilityRepository,
        private SkillReader $skillReader,
        private AbilityReader $abilityReader,
    ) {}
    
    // TODO modifier object en Domain\RpgFeat quand il sera défini
    public function getFeat(DomainOrigin $origin): ?object
    {
        if ($origin->featId <= 0) {
            return null;
        }

        return $this->featRepository->find($origin->featId);
    }

    public function getTool(DomainOrigin $origin): ?object
    {
        if ($origin->toolId <= 0) {
            return null;
        }

        return $this->toolRepository->find($origin->toolId);
    }

    public function getSkills(DomainOrigin $origin): Collection
    {
        $originSkills = $this->originSkillRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $collection = new Collection();
        foreach ($originSkills as $originSkill) {
            $skillId = $originSkill->skillId;
            $skill = $this->skillReader->getSkill($skillId);
            $this->skillCache[$skillId] ??= $skill;
            $collection->addItem($this->skillCache[$skillId]);
        }
        return $collection;
    }

    public function getAbilities(DomainOrigin $origin): Collection
    {
        $originAbilities = $this->originAbilityRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $collection = new Collection();
        foreach ($originAbilities as $originAbility) {
            $abilityId = $originAbility->abilityId;
            $ability = $this->abilityReader->getAbility($abilityId);
            $this->abilityCache[$abilityId] ??= $ability;
            $collection->addItem($this->abilityCache[$abilityId]);
        }
        return $collection;
    }
}
