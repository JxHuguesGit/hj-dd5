<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ViewModel\ToolGroup;
use src\Presenter\ViewModel\ToolRow;
use src\Utils\Html;
use src\Utils\Table;

class ToolTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [L::NAMES, L::HISTORIQUES, L::WEIGHT, L::PRICE];
        $table   = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            /** @var ToolGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var ToolRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([C::CONTENT => $row->originLabel])
                    ->addBodyCell([
                        C::CONTENT    => $row->weight,
                        C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END],
                    ])
                    ->addBodyCell([
                        C::CONTENT    => $row->price,
                        C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END],
                    ]);
            }
        }

        return $table;
    }
}
