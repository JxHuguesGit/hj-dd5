<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Domain\Entity\Weapon;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponFormatter;
use src\Service\Formatter\WeaponPropertiesFormatter;
use src\Service\Reader\WeaponPropertyValueReader;
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
            /** @var Weapon $weapon */
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

    private function buildRow(Weapon $weapon): WeaponRow
    {
        $formatter = new WeaponFormatter(
            $this->wpPostService,
            $this->formatter,
            $this->weaponPropertyValue
        );

        return new WeaponRow(
            name: $weapon->name,
            url: UrlGenerator::item($weapon->slug),
            damage: Utils::getStrDamage($weapon),
            properties: $formatter->properties($weapon),
            masteryLink: $formatter->masteryLink($weapon),
            weight: Utils::getStrWeight($weapon->weight),
            price: Utils::getStrPrice($weapon->goldPrice)
        );
    }

    public static function getWeaponTypes(): array
    {
        return [
            Constant::CST_SIMPLE.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG => Constant::CST_SIMPLE.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => 'Armes simples de mêlée',
                Constant::CST_LABEL_SING => 'Arme simple de mêlée',
            ],
            Constant::CST_SIMPLE.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG => Constant::CST_SIMPLE.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => 'Armes simples à distance',
                Constant::CST_LABEL_SING => 'Arme simple à distance',
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG => Constant::CST_MARTIAL.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => 'Armes martiales de mêlée',
                Constant::CST_LABEL_SING => 'Arme martiale de mêlée',
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG => Constant::CST_MARTIAL.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => 'Armes martiales à distance',
                Constant::CST_LABEL_SING => 'Arme martiale à distance',
            ],
        ];
    }
}
