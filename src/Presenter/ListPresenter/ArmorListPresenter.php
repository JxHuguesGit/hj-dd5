<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Domain\Entity\Armor;
use src\Presenter\ViewModel\ArmorGroup;
use src\Presenter\ViewModel\ArmorRow;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ArmorListPresenter
{
    public function present(iterable $armors): Collection
    {
        $grouped = [];
        foreach ($armors as $armor) {
            /** @var Armor $armor */
            $grouped[$armor->armorTypeId][] = $this->buildRow($armor);
        }

        $typesLabel = self::getTypesLabel();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new ArmorGroup(
                label: $typesLabel[$typeId][Constant::LABEL] ?? '',
                slug: $typesLabel[$typeId][Constant::SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(Armor $armor): ArmorRow
    {
        return new ArmorRow(
            name: $armor->name,
            url: UrlGenerator::item($armor->slug),
            armorClass: $armor->displayArmorClass(),
            strengthPenalty: $armor->strengthPenalty,
            stealth: $armor->stealthDisadvantage ? L::DISADVANTAGE : '-',
            weight: Utils::getStrWeight($armor->weight),
            price: Utils::getStrPrice($armor->goldPrice)
        );
    }

    public static function getTypesLabel(): array
    {
        return [
            Armor::TYPE_LIGHT => [
                Constant::SLUG  => Constant::LIGHT,
                Constant::LABEL => L::ARM_LGT_DONDOFF,
                Constant::NAME  => L::ARM_LGT,
            ],
            Armor::TYPE_MEDIUM => [
                Constant::SLUG => Constant::MEDIUM,
                Constant::LABEL => L::ARM_MDM_DONDOFF,
                Constant::NAME  => L::ARM_MDM,
            ],
            Armor::TYPE_HEAVY => [
                Constant::SLUG => Constant::HEAVY,
                Constant::LABEL => L::ARM_HVY_DONDOFF,
                Constant::NAME  => L::ARM_HVY,
            ],
            Armor::TYPE_SHIELD => [
                Constant::SLUG => Constant::SHIELD,
                Constant::LABEL => L::ARM_SHD_DONDOFF,
                Constant::NAME  => L::ARM_SHD,
            ],
        ];
    }
}
