<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Skill as DomainSkill;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillRow;
use src\Service\Domain\SkillService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SkillListPresenter
{
    public function __construct(private SkillService $skillService) {}

    public function present(iterable $skills): Collection
    {
        $grouped = [];
        foreach ($skills as $skill) {
            $grouped[$skill->abilityId][] = $this->buildRow($skill);
        }

        $types = self::getSkillTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->addItem(new SkillGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(DomainSkill $skill): SkillRow
    {
        return new SkillRow(
            name: $skill->name,
            url: UrlGenerator::skill($skill->slug),
            description: $skill->description,
            subSkills: implode(
                '<br>',
                array_map(
                    fn($s) => Html::getLink(
                        $s->name??'',
                        $s->slug ? UrlGenerator::skill($s->slug) : '#',
                        Bootstrap::CSS_TEXT_DARK
                    ),
                    $this->skillService->subSkills($skill)->items()
                )
            )
        );
    }

    private static function getSkillTypes(): array
    {
        return [
            1 => [Constant::CST_SLUG => Constant::ABLSTR, Constant::CST_LABEL => Language::LG_FORCE],
            2 => [Constant::CST_SLUG => Constant::ABLDEX, Constant::CST_LABEL => Language::LG_DEXTERITE],
            3 => [Constant::CST_SLUG => Constant::ABLCON, Constant::CST_LABEL => Language::LG_CONSTITUTION],
            4 => [Constant::CST_SLUG => Constant::ABLINT, Constant::CST_LABEL => Language::LG_INTELLIGENCE],
            5 => [Constant::CST_SLUG => Constant::ABLWIS, Constant::CST_LABEL => Language::LG_SAGESSE],
            6 => [Constant::CST_SLUG => Constant::ABLCHA, Constant::CST_LABEL => Language::LG_CHARISME],
        ];
    }
}

