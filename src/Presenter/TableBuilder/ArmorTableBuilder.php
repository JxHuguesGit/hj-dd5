<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Utils\Table;
use src\Utils\Utils;

class ArmorTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groupedArmors, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_ARMORS])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_CA])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_FORCE])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_STEALTH])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_WEIGHT])
            ->addHeaderCell([Constant::CST_CONTENT => Language::LG_PRICE]);

        foreach ($groupedArmors as $group) {
            // Ligne de rupture
            $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                  ->addBodyCell([
                      Constant::CST_CONTENT => $group[Constant::CST_TYPELABEL],
                      Constant::CST_ATTRIBUTES => [
                          Constant::CST_COLSPAN => 6,
                          Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                      ]
                  ]);

            // Armures de ce type
            foreach ($group[Constant::ARMORS] as $armor) {
                /** @var DomainArmor $armor */
                $table->addBodyRow([])
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
            }
        }

        return $table;
    }
}
