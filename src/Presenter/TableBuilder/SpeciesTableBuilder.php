<?php
namespace src\Presenter\TableBuilder;

use src\Constant\{Bootstrap, Constant, Language};
use src\Presenter\ViewModel\SpeciesRow;
use src\Utils\{Html, Table};

class SpeciesTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $headers = [Language::LG_NAMES, Language::LG_CREATURE_TYPE, Language::LG_SIZE_CATEGORY, Language::LG_SPEED];
        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($rows as $row) {
            /** @var SpeciesRow $row */
            $table->addBodyRow([])
                ->addBodyCell([
                    Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)
                ])
                ->addBodyCell([Constant::CST_CONTENT => $row->creatureType])
                ->addBodyCell([Constant::CST_CONTENT => $row->sizeCategory])
                ->addBodyCell([
                    Constant::CST_CONTENT => $row->speed,
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]
                ]);
        }

        return $table;
    }
}
