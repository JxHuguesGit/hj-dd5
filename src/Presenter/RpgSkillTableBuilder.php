<?php
namespace src\Presenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Table;
use src\Utils\Utils;

class RpgSkillTableBuilder
{
    public function build(iterable $skills, array $params=[]): Table
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
            ->addHeaderCell([Constant::CST_CONTENT => 'Compétence']);

        foreach ($skills as $group) {
            // Ligne de rupture
            $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
                  ->addBodyCell([
                      Constant::CST_CONTENT => $group['label'],
                      Constant::CST_ATTRIBUTES => [
                          Constant::CST_COLSPAN => 6,
                          Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                      ]
                  ]);

            // Armures de ce type
            foreach ($group['skills'] as $skill) {
                /** @var DomainRpgArmor $skill */
                $table->addBodyRow([])
                      ->addBodyCell([Constant::CST_CONTENT => $skill->name]);
            }
        }

        return $table;
    }
}
