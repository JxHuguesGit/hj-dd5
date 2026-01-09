<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Table;
use src\Utils\Utils;

class WeaponTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groups, array $params=[]): Table
    {
        $withMarginTop = $params['withMarginTop'] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => Bootstrap::CSS_TABLE_DARK])
            ->addHeaderRow()
            ->addHeaderCell(['content' => 'Arme'])
            ->addHeaderCell(['content' => 'Dégâts'])
            ->addHeaderCell(['content' => 'Propriétés'])
            ->addHeaderCell(['content' => 'Botte'])
            ->addHeaderCell(['content' => 'Poids'])
            ->addHeaderCell(['content' => 'Prix']);

        foreach ($groups as $group) {
            if (empty($group['weapons'])) {
                continue;
            }

            // Ligne de séparation
            $table->addBodyRow([Constant::CST_CLASS => 'row-dark-striped'])
                ->addBodyCell([
                    Constant::CST_CONTENT => $group['label'],
                    Constant::CST_ATTRIBUTES => [
                        'colspan' => 6,
                        Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                    ]
                ]);

            foreach ($group['weapons'] as $weapon) {
                /** @var Weapon $weapon */

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
                    ->addBodyCell(['content' => $weapon->name])
                    ->addBodyCell(['content' => $strDegats])
                    ->addBodyCell(['content' => $strProps])
                    ->addBodyCell(['content' => $mastery])
                    ->addBodyCell([
                        'content' => Utils::getStrWeight($weapon->weight),
                        'attributes' => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                    ])
                    ->addBodyCell([
                        'content' => Utils::getStrPrice($weapon->goldPrice),
                        'attributes' => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
                    ]);
            }
        }

        return $table;

    }
}
