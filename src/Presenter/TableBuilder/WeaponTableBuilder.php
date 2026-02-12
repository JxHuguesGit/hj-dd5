<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Utils\Table;
use src\Constant\Language;
use src\Utils\Html;

class WeaponTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [Language::LG_WEAPONS, Language::LG_DAMAGES, Language::LG_PROPERTIES, Language::LG_WEAPON_PROP, Language::LG_WEIGHT, Language::LG_PRICE];
        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            /** @var WeaponGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var WeaponRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $row->damage])
                    ->addBodyCell([Constant::CST_CONTENT => $row->properties])
                    ->addBodyCell([Constant::CST_CONTENT => $row->masteryLink])
                    ->addBodyCell([Constant::CST_CONTENT => $row->weight])
                    ->addBodyCell([Constant::CST_CONTENT => $row->price]);
            }
        }

        return $table;
    }
}
