<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Domain\Weapon as DomainWeapon;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Service\WpPostService;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;
use src\Constant\Bootstrap;

final class WeaponListPresenter
{
    public function __construct(private WpPostService $wpPostService) {}

    public function present(iterable $weapons): array
    {
        $grouped = [];
        foreach ($weapons as $weapon) {
            /** @var DomainWeapon $weapon */
            $key = ($weapon->isMartial() ? Constant::CST_MARTIAL : Constant::CST_SIMPLE) . '_'
                 . ($weapon->isMelee() ? Constant::CST_MELEE : Constant::CST_RANGED);
            $grouped[$key][] = $this->buildRow($weapon);
        }

        $types = self::getWeaponTypes();
        $result = [];
        foreach ($grouped as $typeId => $rows) {
            $result[] = new WeaponGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            );
        }

        return [Constant::CST_ITEMS => $result];
    }

    private function buildRow(DomainWeapon $weapon): WeaponRow
    {
        return new WeaponRow(
            name: $weapon->name,
            url: UrlGenerator::item($weapon->slug),
            damage: Utils::getStrDamage($weapon),
            properties: '', // TODO: Utils::getWeaponProperties($weapon)
            masteryLink: $this->masteryLink($weapon),
            weight: Utils::getStrWeight($weapon->weight),
            price: Utils::getStrPrice($weapon->goldPrice)
        );
    }

    private function masteryLink(DomainWeapon $weapon): string
    {
        $this->wpPostService->getById($weapon->masteryPostId);
        $linkContent = $weapon->masteryName
            . Html::getSpan($this->wpPostService->getPostContent() ?? '', [Constant::CST_CLASS=>'tooltip-text']);
        return Html::getLink($linkContent, '#', Bootstrap::CSS_TEXT_DARK.' tooltip-trigger');
    }

    private static function getWeaponTypes(): array
    {
        return [
            Constant::CST_SIMPLE.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG => Constant::CST_SIMPLE.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => 'Armes simples de mêlée',
            ],
            Constant::CST_SIMPLE.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG => Constant::CST_SIMPLE.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => 'Armes simples à distance',
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG => Constant::CST_MARTIAL.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => 'Armes martiales de mêlée',
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG => Constant::CST_MARTIAL.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => 'Armes martiales à distance',
            ],
        ];
    }
}
