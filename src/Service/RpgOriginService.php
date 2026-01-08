<?php
namespace src\Service;

use src\Constant\Field;
use src\Collection\Collection;
use src\Domain\RpgOrigin;
use src\Domain\RpgTool as DomainRpgTool;
use src\Repository\RpgFeat;
use src\Repository\RpgTool;
use src\Repository\RpgOriginAbility;
use src\Repository\RpgOriginSkill;
use src\Service\RpgAbilityQueryService;
use src\Service\RpgSkillQueryService;

final class RpgOriginService
{
    /** @var array<int, RpgAbility> */
    private array $abilityCache = [];
    /** @var array<int, RpgSkill> */
    private array $skillCache = [];
    
    public function __construct(
        private RpgFeat $featRepository,
        private RpgTool $toolRepository,
        private RpgOriginSkill $originSkillRepository,
        private RpgOriginAbility $originAbilityRepository,
        private RpgSkillQueryService $skillQueryService,
        private RpgAbilityQueryService $abilityQueryService,
    ) {}
    
    // TODO modifier object en Domain\RpgFeat quand il sera défini
    public function getFeat(RpgOrigin $origin): ?object
    {
        if ($origin->featId <= 0) {
            return null;
        }

        return $this->featRepository->find($origin->featId);
    }

    public function getTool(RpgOrigin $origin): ?object
    {
        if ($origin->toolId <= 0) {
            return null;
        }

        return null;//$this->toolRepository->find($origin->toolId);
    }

    public function getSkills(RpgOrigin $origin): Collection
    {
        $originSkills = $this->originSkillRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $abilities = [];
        $collection = new Collection();

        foreach ($originSkills as $originSkill) {
            $skillId = $originSkill->skillId;
              $skill = $this->skillQueryService->getSkill($skillId);

            if (!isset($this->skillCache[$skillId])) {
                $this->skillCache[$skillId] = $skill;
            }

            $skills[] = $this->skillCache[$skillId];
            $collection->addItem($skill);
        }

        return $collection;
    }

    public function getAbilities(RpgOrigin $origin): Collection
    {
        $originAbilities = $this->originAbilityRepository->findBy([
            Field::ORIGINID => $origin->id
        ]);

        $abilities = [];
        $collection = new Collection();

        foreach ($originAbilities as $originAbility) {
            $abilityId = $originAbility->abilityId;
              $ability = $this->abilityQueryService->getAbility($abilityId);

            if (!isset($this->abilityCache[$abilityId])) {
                $this->abilityCache[$abilityId] = $ability;
            }

            $abilities[] = $this->abilityCache[$abilityId];
            $collection->addItem($ability);
        }

        return $collection;
    }
}