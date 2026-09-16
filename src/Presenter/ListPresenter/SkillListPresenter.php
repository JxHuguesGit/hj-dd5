<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Entity\Skill;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillLink;
use src\Presenter\ViewModel\SkillRow;
use src\Service\Reader\SkillReader;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class SkillListPresenter
{
    public function __construct(
        private SkillReader $skillReader
    ) {}

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
        $criteria = new SkillCriteria();
        $criteria->parentId = $skill->id;
        return new SkillRow(
            id: $skill->id,
            name: $skill->name,
            url: UrlGenerator::skill($skill->slug),
            description: Utils::formatBBCode(trim(strip_tags($skill->description ?? ''))),
            subSkills: array_map(
                fn(Skill $s) => new SkillLink(
                    name: $s->name ?? '',
                    url: $s->slug ? UrlGenerator::skill($s->slug) : '#',
                ),
                $this->skillReader->allSkills($criteria)->toArray()
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
