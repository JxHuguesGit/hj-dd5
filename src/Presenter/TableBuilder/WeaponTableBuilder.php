<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ViewModel\WeaponGroup;
use src\Presenter\ViewModel\WeaponRow;
use src\Utils\Html;
use src\Utils\Table;

class WeaponTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [
            L::NAMES,
            L::DAMAGES,
            L::PROPERTIES,
            L::WEAPON_PROP,
            L::WEIGHT,
            L::PRICE,
        ];
        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            /** @var WeaponGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var WeaponRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        C::CONTENT => Html::getLink(
                            $row->name,
                            $row->url,
                            B::TEXT_DARK
                        ),
                    ])
                    ->addBodyCell([C::CONTENT => $row->damage])
                    ->addBodyCell([C::CONTENT => $row->properties])
                    ->addBodyCell([C::CONTENT => $row->masteryLink])
                    ->addBodyCell([C::CONTENT => $row->weight])
                    ->addBodyCell([C::CONTENT => $row->price]);
            }
        }

        return $table;
    }
}
