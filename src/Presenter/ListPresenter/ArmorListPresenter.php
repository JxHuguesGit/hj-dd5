<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Armor as DomainArmor;
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
            /** @var DomainArmor $armor */
            $grouped[$armor->armorTypeId][] = $this->buildRow($armor);
        }

        $typesLabel = self::getTypesLabel();
        $collection = new Collection();
        foreach ($grouped as $typeId => $rows) {
            $collection->add(new ArmorGroup(
                label: $typesLabel[$typeId][Constant::CST_LABEL] ?? '',
                slug: $typesLabel[$typeId][Constant::CST_SLUG] ?? '',
                rows: $rows
            ));
        }

        return $collection;
    }

    private function buildRow(DomainArmor $armor): ArmorRow
    {
        return new ArmorRow(
            name: $armor->name,
            url: UrlGenerator::item($armor->slug),
            armorClass: $armor->displayArmorClass(),
            strengthPenalty: $armor->strengthPenalty,
            stealth: $armor->stealthDisadvantage ? Language::LG_DISADVANTAGE : '-',
            weight: Utils::getStrWeight($armor->weight),
            price: Utils::getStrPrice($armor->goldPrice)
        );
    }

    public static function getTypesLabel(): array
    {
        return [
            DomainArmor::TYPE_LIGHT => [
                Constant::CST_SLUG  => Constant::LIGHT,
                Constant::CST_LABEL => Language::LG_ARM_LGT_DONDOFF,
                Constant::CST_NAME  => Language::LG_ARM_LGT,
            ],
            DomainArmor::TYPE_MEDIUM => [
                Constant::CST_SLUG => Constant::MEDIUM,
                Constant::CST_LABEL => Language::LG_ARM_MDM_DONDOFF,
                Constant::CST_NAME  => Language::LG_ARM_MDM,
            ],
            DomainArmor::TYPE_HEAVY => [
                Constant::CST_SLUG => Constant::HEAVY,
                Constant::CST_LABEL => Language::LG_ARM_HVY_DONDOFF,
                Constant::CST_NAME  => Language::LG_ARM_HVY,
            ],
            DomainArmor::TYPE_SHIELD => [
                Constant::CST_SLUG => Constant::SHIELD,
                Constant::CST_LABEL => Language::LG_ARM_SHD_DONDOFF,
                Constant::CST_NAME  => Language::LG_ARM_SHD,
            ],
        ];
    }
}
