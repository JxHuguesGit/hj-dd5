<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Domain\Skill as DomainSkill;

class SkillListPresenter
{
    /**
     * Transforme la collection de compétences en tableau prêt à être rendu par la Page.
     */
    public function present(Collection $skills): array
    {
        $grouped = [];
        foreach ($skills as $skill) {
            /** @var DomainSkill $skill */
            $grouped[$skill->abilityId][] = $skill;
        }

        $typesLabel = [
            1 => Constant::ABLSTR,
            2 => Constant::ABLDEX,
            3 => Constant::ABLCON,
            4 => Constant::ABLINT,
            5 => Constant::ABLWIS,
            6 => Constant::ABLCHA,
        ];

        $result = [];
        foreach ($grouped as $typeId => $skillsByType) {
            $result[] = [
                Constant::CST_TYPELABEL => $typesLabel[$typeId] ?? '',
                Constant::CST_SKILLS => $skillsByType
            ];
        }

        return [Constant::CST_ITEMS=>$result];
    }
}
