<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Utils\Html;
use src\Utils\Table;

abstract class AbstractTableBuilder implements TableBuilderInterface
{
    protected function createTable(int $colCount, array $params = []): Table
    {
        $withMarginTop   = $params[B::WITH_MRGNTOP] ?? true;
        $tableAttributes = [
            C::CSSCLASS => implode(' ', [
                B::TABLE_SM,
                B::TABLE_STRIPED,
                $withMarginTop ? B::MT5 : '',
            ]),
        ];
        if (isset($params[C::ID])) {
            $tableAttributes[C::ID] = $params[C::ID];
        }
        if (isset($params[C::TARGET])) {
            $tableAttributes[C::TARGET] = $params[C::TARGET];
        }
        return (new Table())
            ->setTable($tableAttributes)
            ->addHeader([
                C::CSSCLASS => implode(' ', [
                    B::TABLE_DARK,
                    B::TEXT_CENTER,
                ]),
            ])
            ->addHeaderRow();
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
    {
        $table->addBodyRow([C::CSSCLASS => B::ROW_DARK_STRIPED])
            ->addBodyCell([
                C::CONTENT    => $label,
                C::ATTRIBUTES => [
                    C::COLSPAN => $colspan,
                    C::CSSCLASS   => B::FONT_ITALIC,
                ],
            ]);
    }

    protected function addHeader(Table $table, array $headers): self
    {
        foreach ($headers as $data) {
            if (! is_array($data)) {
                $table->addHeaderCell([C::CONTENT => $data]);
            } else {
                if (isset($data['abbr'])) {
                    $strContent = Html::getBalise('abbr', $data[C::LABEL], [C::TITLE => $data['abbr']]);
                } else {
                    $strContent = $data[C::LABEL];
                }

                if ($data['filter'] ?? false) {
                    $strContent = Html::getDiv(
                        $strContent . ' ' . Html::getIcon(
                            I::FITLER,
                            I::SOLID,
                            [
                                C::CSSCLASS => 'modal-tooltip ajaxAction',
                                C::DATA  => [
                                    C::TRIGGER => C::CLICK,
                                    C::ACTION  => C::OPENMODAL,
                                    C::TARGET  => $table->attributes[C::TARGET],
                                ],
                            ]
                        ),
                        [C::CSSCLASS => B::TEXT_NOWRAP]
                    );
                }
                $table->addHeaderCell([C::CONTENT => $strContent]);

            }
        }
        return $this;
    }
}
