<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
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
            $key = ($weapon->isMartial() ? C::MARTIAL : C::SIMPLE) . '_'
                 . ($weapon->isMelee() ? C::MELEE : C::RANGED);
            $grouped[$key][] = $this->buildRow($weapon);
        }

        $types = self::getWeaponTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new WeaponGroup(
                label: $types[$typeId][C::LABEL] ?? '',
                slug: $types[$typeId][C::SLUG] ?? '',
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
            C::SIMPLE.'_'.C::MELEE => [
                C::SLUG => C::SIMPLE.'_'.C::MELEE,
                C::LABEL => 'Armes simples de mêlée',
                C::LABEL_SING => 'Arme simple de mêlée',
            ],
            C::SIMPLE.'_'.C::RANGED => [
                C::SLUG => C::SIMPLE.'_'.C::RANGED,
                C::LABEL => 'Armes simples à distance',
                C::LABEL_SING => 'Arme simple à distance',
            ],
            C::MARTIAL.'_'.C::MELEE => [
                C::SLUG => C::MARTIAL.'_'.C::MELEE,
                C::LABEL => 'Armes martiales de mêlée',
                C::LABEL_SING => 'Arme martiale de mêlée',
            ],
            C::MARTIAL.'_'.C::RANGED => [
                C::SLUG => C::MARTIAL.'_'.C::RANGED,
                C::LABEL => 'Armes martiales à distance',
                C::LABEL_SING => 'Arme martiale à distance',
            ],
        ];
    }
}
