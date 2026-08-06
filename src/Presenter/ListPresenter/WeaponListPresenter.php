<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Domain\Entity\Weapon;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Service\Formatter\WeaponFormatter;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class WeaponListPresenter
{
    public function __construct(
        private WeaponFormatter $formatter
    ) {}

    /** @param Collection<Weapon> $weapons */
    public function present(Collection $weapons): Collection
    {
        $grouped = [];
        foreach ($weapons as $weapon) {
            $key = ($weapon->isMartial() ? C::MARTIAL : C::SIMPLE) . '_'
                 . ($weapon->isMelee() ? C::MELEE : C::RANGED);
            $grouped[$key][] = $this->buildRow($weapon);
        }

        $types = self::getWeaponTypes();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new WeaponGroup(
                label: $types[$typeId][C::LABEL],
                slug: $types[$typeId][C::SLUG],
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Weapon $weapon): WeaponRow
    {
        return new WeaponRow(
            name: $weapon->name,
            url: UrlGenerator::item($weapon->slug),
            damage: Utils::getStrDamage($weapon),
            properties: $this->formatter->properties($weapon),
            masteryLink: $this->formatter->masteryLink($weapon),
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
