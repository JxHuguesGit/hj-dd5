<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Skill as DomainSkill;
use src\Presenter\ViewModel\SkillPageView;
use src\Service\Domain\SkillService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\SkillReader;

final class SkillPageService
{
    public function __construct(
        private SkillService $skillService,
        private SkillReader $skillReader,
        private AbilityReader $abilityReader,
    ) {}

    public function build(DomainSkill $skill): SkillPageView
    {
        $nav = $this->skillReader->getPreviousAndNext($skill);
        $subSkills = $this->skillService->subSkills($skill);
        $ability = $this->abilityReader->abilityById($skill->abilityId);
        $origins = $this->skillService->getOrigines($skill);

        return new SkillPageView(
            $skill,
            $subSkills,
            $ability,
            $origins,
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
        );
    }
}
