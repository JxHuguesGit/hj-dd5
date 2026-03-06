<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Entity\Skill;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillRow;
use src\Service\Domain\SkillService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class SkillListPresenter
{
    public function __construct(private SkillService $skillService)
    {}

    public function present(iterable $skills): Collection
    {
        $grouped = [];
        foreach ($skills as $skill) {
            $grouped[$skill->abilityId][] = $this->buildRow($skill);
        }

        $types      = self::getSkillTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new SkillGroup(
                label: $types[$typeId][C::LABEL] ?? '',
                slug: $types[$typeId][C::SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Skill $skill): SkillRow
    {
        return new SkillRow(
            name: $skill->name,
            url: UrlGenerator::skill($skill->slug),
            description: $skill->description,
            subSkills: implode(
                '<br>',
                array_map(
                    fn($s) => Html::getLink(
                        $s->name ?? '',
                        $s->slug ? UrlGenerator::skill($s->slug) : '#',
                        B::TEXT_DARK
                    ),
                    $this->skillService->subSkills($skill)->toArray()
                )
            )
        );
    }

    private static function getSkillTypes(): array
    {
        return [
            1 => [C::SLUG => C::ABLSTR, C::LABEL => L::FORCE],
            2 => [C::SLUG => C::ABLDEX, C::LABEL => L::DEXTERITE],
            3 => [C::SLUG => C::ABLCON, C::LABEL => L::CONSTITUTION],
            4 => [C::SLUG => C::ABLINT, C::LABEL => L::INTELLIGENCE],
            5 => [C::SLUG => C::ABLWIS, C::LABEL => L::SAGESSE],
            6 => [C::SLUG => C::ABLCHA, C::LABEL => L::CHARISME],
        ];
    }
}
