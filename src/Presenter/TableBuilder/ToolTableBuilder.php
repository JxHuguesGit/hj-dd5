<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\ToolGroup;
use src\Presenter\ViewModel\ToolRow;
use src\Utils\Table;
use src\Constant\Language;
use src\Utils\Html;

class ToolTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [Language::LG_TOOLS, Language::LG_ORIGINS, Language::LG_WEIGHT, Language::LG_PRICE];
        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            /** @var ToolGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var ToolRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $row->originLabel])
                    ->addBodyCell([Constant::CST_CONTENT => $row->weight, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]])
                    ->addBodyCell([Constant::CST_CONTENT => $row->price, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]]);
            }
        }

        return $table;
    }
}
