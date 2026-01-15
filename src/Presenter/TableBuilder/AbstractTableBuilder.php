<?php
namespace src\Presenter\TableBuilder;

use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Bootstrap;
use src\Constant\Constant;

abstract class AbstractTableBuilder implements TableBuilderInterface
{
    protected function createTable(int $colCount, array $params = []): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;
        return (new Table())->setTable([
            Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])
        ])->addHeader([
            Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_DARK,
                Bootstrap::CSS_TEXT_CENTER
            ])
        ])->addHeaderRow();
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
    {
        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT => $label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => $colspan,
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                ]
            ]);
    }
}
