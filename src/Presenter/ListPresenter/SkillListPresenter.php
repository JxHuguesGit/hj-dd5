<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Skill as DomainSkill;
use src\Presenter\ViewModel\SkillGroup;

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

        $types = self::getSkillTypes();

        $result = [];
        foreach ($grouped as $typeId => $skillsByType) {
            $result[] = new SkillGroup(
                $types[$typeId][Constant::CST_LABEL] ?? '',
                $types[$typeId][Constant::CST_SLUG] ?? '',
                $skillsByType
            );
        }

        return [Constant::CST_ITEMS=>$result];
    }

    private function getSkillTypes(): array
    {
        return [
            1 => [
                Constant::CST_SLUG  => Constant::ABLSTR,
                Constant::CST_LABEL => Language::LG_FORCE,
            ],
            2 => [
                Constant::CST_SLUG  => Constant::ABLDEX,
                Constant::CST_LABEL => Language::LG_DEXTERITE,
            ],
            3 => [
                Constant::CST_SLUG  => Constant::ABLCON,
                Constant::CST_LABEL => Language::LG_CONSTITUTION,
            ],
            4 => [
                Constant::CST_SLUG  => Constant::ABLINT,
                Constant::CST_LABEL => Language::LG_INTELLIGENCE,
            ],
            5 => [
                Constant::CST_SLUG  => Constant::ABLWIS,
                Constant::CST_LABEL => Language::LG_SAGESSE,
            ],
            6 => [
                Constant::CST_SLUG  => Constant::ABLCHA,
                Constant::CST_LABEL => Language::LG_CHARISME,
            ],
        ];
    }
}
