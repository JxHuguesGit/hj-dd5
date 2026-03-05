<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Utils\Html;
use src\Utils\Table;

abstract class AbstractTableBuilder implements TableBuilderInterface
{
    protected function createTable(int $colCount, array $params = []): Table
    {
        $withMarginTop   = $params[B::WITH_MRGNTOP] ?? true;
        $tableAttributes = [
            Constant::CST_CLASS => implode(' ', [
                B::TABLE_SM,
                B::TABLE_STRIPED,
                $withMarginTop ? B::MT5 : '',
            ]),
        ];
        if (isset($params[Constant::CST_ID])) {
            $tableAttributes[Constant::CST_ID] = $params[Constant::CST_ID];
        }
        if (isset($params[Constant::CST_TARGET])) {
            $tableAttributes[Constant::CST_TARGET] = $params[Constant::CST_TARGET];
        }
        return (new Table())
            ->setTable($tableAttributes)
            ->addHeader([
                Constant::CST_CLASS => implode(' ', [
                    B::TABLE_DARK,
                    B::TEXT_CENTER,
                ]),
            ])
            ->addHeaderRow();
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
    {
        $table->addBodyRow([Constant::CST_CLASS => B::ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT    => $label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => $colspan,
                    Constant::CST_CLASS   => B::FONT_ITALIC,
                ],
            ]);
    }

    protected function addHeader(Table $table, array $headers): self
    {
        foreach ($headers as $data) {
            if (! is_array($data)) {
                $table->addHeaderCell([Constant::CST_CONTENT => $data]);
            } else {
                if (isset($data['abbr'])) {
                    $strContent = Html::getBalise('abbr', $data[Constant::CST_LABEL], [Constant::CST_TITLE => $data['abbr']]);
                } else {
                    $strContent = $data[Constant::CST_LABEL];
                }

                if ($data['filter'] ?? false) {
                    $strContent = Html::getDiv(
                        $strContent . ' ' . Html::getIcon(
                            Icon::IFITLER,
                            Icon::SOLID,
                            [
                                Constant::CST_CLASS => 'modal-tooltip ajaxAction',
                                Constant::CST_DATA  => [
                                    Constant::CST_TRIGGER => Constant::CST_CLICK,
                                    Constant::CST_ACTION  => Constant::CST_OPENMODAL,
                                    Constant::CST_TARGET  => $table->attributes[Constant::CST_TARGET],
                                ],
                            ]
                        ),
                        [Constant::CST_CLASS => B::TEXT_NOWRAP]
                    );
                }
                $table->addHeaderCell([Constant::CST_CONTENT => $strContent]);

            }
        }
        return $this;
    }
}
