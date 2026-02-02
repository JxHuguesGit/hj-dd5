<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Domain\Weapon as DomainWeapon;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\WeaponPropertyValueReader;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class WeaponListPresenter
{
    public function __construct(
        private WpPostService $wpPostService,
        private WeaponPropertiesFormatter $formatter,
        private WeaponPropertyValueReader $weaponPropertyValue
    ) {}

    public function present(iterable $weapons): Collection
    {
        $grouped = [];
        foreach ($weapons as $weapon) {
            /** @var DomainWeapon $weapon */
            $key = ($weapon->isMartial() ? Constant::CST_MARTIAL : Constant::CST_SIMPLE) . '_'
                 . ($weapon->isMelee() ? Constant::CST_MELEE : Constant::CST_RANGED);
            $grouped[$key][] = $this->buildRow($weapon);
        }

        $types = self::getWeaponTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new WeaponGroup(
                label: $types[$typeId][Constant::CST_LABEL] ?? '',
                slug: $types[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(DomainWeapon $weapon): WeaponRow
    {
        return new WeaponRow(
            name: $weapon->name,
            url: UrlGenerator::item($weapon->slug),
            damage: Utils::getStrDamage($weapon),
            properties: $this->properties($weapon),
            masteryLink: $this->masteryLink($weapon),
            weight: Utils::getStrWeight($weapon->weight),
            price: Utils::getStrPrice($weapon->goldPrice)
        );
    }

    private function properties(DomainWeapon $weapon): string
    {
        $weaponPropertyValues = $this->weaponPropertyValue->byWeaponId($weapon->id);
        if ($weaponPropertyValues->isEmpty()) {
            return '-';
        }
        
        $parts = [];
        foreach ($weaponPropertyValues as $weaponPropertyValue) {
            $parts[] = $this->formatter->format($weaponPropertyValue, $this->wpPostService);
        }
        return implode(', ', $parts);
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
