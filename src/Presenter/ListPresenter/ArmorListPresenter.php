<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Armor as DomainArmor;
use src\Presenter\ViewModel\ArmorGroup;

class ArmorListPresenter
{
    /**
     * Transforme une liste d'armures en tableau prêt pour le Renderer.
     * Groupé par type.
     */
    public function present(iterable $armors): array
    {
        $grouped = [];
        foreach ($armors as $armor) {
            /** @var DomainArmor $armor */
            $grouped[$armor->armorTypeId][] = $armor;
        }

        $typesLabel = self::getTypesLabel();

        $result = [];
        foreach ($grouped as $typeId => $armorsByType) {
            $result[] = new ArmorGroup(
                $typesLabel[$typeId][Constant::CST_LABEL] ?? '',
                $typesLabel[$typeId][Constant::CST_SLUG] ?? '',
                $armorsByType
            );
        }

        return [Constant::CST_ITEMS=>$result];
    }

    /**
     * Labels des types d'armure.
     * @return array<int,string>
     */
    private static function getTypesLabel(): array {
        return [
            DomainArmor::TYPE_LIGHT  => [
                Constant::CST_SLUG=>Constant::LIGHT,
                Constant::CST_LABEL=>Language::LG_ARM_LGT_DONDOFF,
            ],
            DomainArmor::TYPE_MEDIUM  => [
                Constant::CST_SLUG=>Constant::MEDIUM,
                Constant::CST_LABEL=>Language::LG_ARM_MDM_DONDOFF,
            ],
            DomainArmor::TYPE_HEAVY  => [
                Constant::CST_SLUG=>Constant::HEAVY,
                Constant::CST_LABEL=>Language::LG_ARM_HVY_DONDOFF,
            ],
            DomainArmor::TYPE_SHIELD  => [
                Constant::CST_SLUG=>Constant::SHIELD,
                Constant::CST_LABEL=>Language::LG_ARM_SHD_DONDOFF,
            ],
        ];
    }
 }
