<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\SpeciesRow;
use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Language;

class SpeciesTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $table = $this->createTable(4, $params);

        foreach ([Language::LG_SPECIE, Language::LG_CREATURE_TYPE, Language::LG_SIZE_CATEGORY, Language::LG_SPEED] as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($rows as $row) {
            /** @var SpeciesRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                ->addBodyCell([Constant::CST_CONTENT => $row->creatureType])
                ->addBodyCell([Constant::CST_CONTENT => $row->sizeCategory])
                ->addBodyCell([Constant::CST_CONTENT => $row->speed, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]]);
        }

        return $table;
    }
}
