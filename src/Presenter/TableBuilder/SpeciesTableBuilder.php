<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpeciesRow;
use src\Utils\Html;
use src\Utils\Table;

class SpeciesTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $headers = [L::NAMES, L::CREATURE_TYPE, L::SIZE_CATEGORY, L::SPEED];
        $table   = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            /** @var SpeciesRow $row */
            $table->addBodyRow([])
                ->addBodyCell([
                    Constant::CST_CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                ])
                ->addBodyCell([Constant::CST_CONTENT => $row->creatureType])
                ->addBodyCell([Constant::CST_CONTENT => $row->sizeCategory])
                ->addBodyCell([
                    Constant::CST_CONTENT    => $row->speed,
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER],
                ]);
        }

        return $table;
    }
}
