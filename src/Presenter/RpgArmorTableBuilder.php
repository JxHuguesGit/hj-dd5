<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Table;
use src\Utils\Utils;

class RpgArmorTableBuilder
{
    public function build(iterable $groupedArmors, array $params=[]): Table
    {
        $withMarginTop = $params['withMarginTop'] ?? true;
    
        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow()
            ->addHeaderCell([Constant::CST_CONTENT => 'Armure'])
            ->addHeaderCell([Constant::CST_CONTENT => 'CA'])
            ->addHeaderCell([Constant::CST_CONTENT => 'Force'])
            ->addHeaderCell([Constant::CST_CONTENT => 'Discrétion'])
            ->addHeaderCell([Constant::CST_CONTENT => 'Poids'])
            ->addHeaderCell([Constant::CST_CONTENT => 'Prix']);

        foreach ($groupedArmors as $group) {
            // Ligne de rupture
            $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                  ->addBodyCell([
                      Constant::CST_CONTENT => $group['typeLabel'],
                      Constant::CST_ATTRIBUTES => [
                          Constant::CST_COLSPAN => 6,
                          Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                      ]
                  ]);

            // Armures de ce type
            foreach ($group['armors'] as $armor) {
                /** @var DomainRpgArmor $armor */
                $table->addBodyRow([])
                      ->addBodyCell([Constant::CST_CONTENT => $armor->name])
                      ->addBodyCell([Constant::CST_CONTENT => $armor->displayArmorClass()])
                      ->addBodyCell([
                          Constant::CST_CONTENT => $armor->strengthPenalty ?: '-',
                          Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]
                      ])
                      ->addBodyCell([Constant::CST_CONTENT => $armor->stealthDisadvantage ? 'Désavantage' : '-'])
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
