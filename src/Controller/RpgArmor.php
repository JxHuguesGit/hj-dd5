<?php
namespace src\Controller;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\RpgArmor as DomainRpgArmor;
use src\Utils\Table;
use src\Utils\Utils;

class RpgArmor extends Utilities
{
    public function __construct()
    {
        parent::__construct();
        $this->title = Language::LG_ARMORS;
    }

    public function getContentPage(): string
    {
        return 'WIP RpgArmor::getContentPage';
    }

    public static function getTable(iterable $armors, array $params=[]): Table
    {
        $withMarginTop = $params['withMarginTop'] ?? true;
    
        $objTable = new Table();
        $objTable->setTable([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_SM, Bootstrap::CSS_TABLE_STRIPED, $withMarginTop ? Bootstrap::CSS_MT5 : ''])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ARMORS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_CA])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_FORCE])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_STEALTH])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_WEIGHT])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_PRICE]);

        $oldTypeArmorId = null;

        foreach ($armors as $armor) {
            /** @var DomainRpgArmor $armor */
            $typeArmorId = $armor->armorTypeId;

            // Si changement de type d'armure, ajouter une ligne de séparation
            if ($oldTypeArmorId !== $typeArmorId) {
                $libelle = match ($typeArmorId) {
                    1 => Language::LG_ARM_LGT_DONDOFF,
                    2 => Language::LG_ARM_MDM_DONDOFF,
                    3 => Language::LG_ARM_HVY_DONDOFF,
                    default => Language::LG_ARM_SHD_DONDOFF,
                };
                $objTable->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                    ->addBodyCell([
                        Constant::CST_CONTENT => $libelle,
                        Constant::CST_ATTRIBUTES => [
                            Constant::CST_COLSPAN => 6,
                            Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                        ]
                    ]);
            }

            $objTable->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $armor->name])
                ->addBodyCell([Constant::CST_CONTENT => $armor->displayArmorClass()])
                ->addBodyCell([
                    Constant::CST_CONTENT => $armor->strengthPenalty ?: '-',
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]
                ])
                ->addBodyCell([Constant::CST_CONTENT => $armor->stealthDisadvantage ? Language::LG_DISADVANTAGE : '-'])
                ->addBodyCell([
                    Constant::CST_CONTENT => Utils::getStrWeight($armor->weight),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                ])
                ->addBodyCell([
                    Constant::CST_CONTENT => Utils::getStrPrice($armor->goldPrice),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                ]);

            $oldTypeArmorId = $typeArmorId;
        }

        return $objTable;
    }
}
