<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
                    C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                ])
                ->addBodyCell([C::CONTENT => $row->creatureType])
                ->addBodyCell([C::CONTENT => $row->sizeCategory])
                ->addBodyCell([
                    C::CONTENT    => $row->speed,
                    C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER],
                ]);
        }

        return $table;
    }
}
