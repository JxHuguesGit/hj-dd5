<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Weapon as DomainWeapon;
use src\Utils\Table;
use src\Utils\Utils;

class WeaponTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groups, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => Bootstrap::CSS_TABLE_DARK])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_WEAPONS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_DAMAGES])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_PROPERTIES])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_WEAPON_PROP])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_WEIGHT])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_PRICE]);

        foreach ($groups as $group) {
            if (empty($group[Constant::WEAPONS])) {
                continue;
            }

            // Ligne de séparation
            $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                ->addBodyCell([
                    Constant::CST_CONTENT => $group[Constant::CST_TYPELABEL],
                    Constant::CST_ATTRIBUTES => [
                        Constant::CST_COLSPAN => 6,
                        Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                    ]
                ]);

            foreach ($group[Constant::WEAPONS] as $weapon) {
                /** @var DomainWeapon $weapon */

                // Dégâts
                $strDegats = $weapon->getDamageDie();

                // Propriétés
                /*
                $props = [];
                foreach ($weapon->getWeaponProficiencies() as $prop) {
                    $props[] = $prop->getStrName();
                }
                $strProps = $props ? implode(', ', $props) : '-';
                */
                $strProps = 'TODO';

                // Botte
                $mastery = $weapon->masteryName;

                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => $weapon->name])
                    ->addBodyCell([Constant::CST_CONTENT => $strDegats])
                    ->addBodyCell([Constant::CST_CONTENT => $strProps])
                    ->addBodyCell([Constant::CST_CONTENT => $mastery])
                    ->addBodyCell([
                        Constant::CST_CONTENT => Utils::getStrWeight($weapon->weight),
                        Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                    ])
                    ->addBodyCell([
                        Constant::CST_CONTENT => Utils::getStrPrice($weapon->goldPrice),
                        Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                    ]);
            }
        }

        return $table;

    }
}
