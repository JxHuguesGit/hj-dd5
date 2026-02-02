<?php
namespace src\Service\Page;

use src\Constant\Constant;
use src\Domain\Skill as DomainSkill;
use src\Presenter\ViewModel\SkillPageView;
use src\Service\Domain\SkillService;
use src\Service\Reader\SkillReader;

final class SkillPageService
{
    public function __construct(
        private SkillService $skillService,
        private SkillReader $skillReader,
    ) {}

    public function build(DomainSkill $skill): SkillPageView
    {
        $nav = $this->skillReader->getPreviousAndNext($skill);

        return new SkillPageView(
            $skill,
            $nav[Constant::CST_PREV],
            $nav[Constant::CST_NEXT],
        );
    }
}
