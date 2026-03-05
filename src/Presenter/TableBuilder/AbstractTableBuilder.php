<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Icon as I;
use src\Utils\Html;
use src\Utils\Table;

abstract class AbstractTableBuilder implements TableBuilderInterface
{
    protected function createTable(int $colCount, array $params = []): Table
    {
        $withMarginTop   = $params[B::WITH_MRGNTOP] ?? true;
        $tableAttributes = [
            Constant::CSSCLASS => implode(' ', [
                B::TABLE_SM,
                B::TABLE_STRIPED,
                $withMarginTop ? B::MT5 : '',
            ]),
        ];
        if (isset($params[Constant::ID])) {
            $tableAttributes[Constant::ID] = $params[Constant::ID];
        }
        if (isset($params[Constant::TARGET])) {
            $tableAttributes[Constant::TARGET] = $params[Constant::TARGET];
        }
        return (new Table())
            ->setTable($tableAttributes)
            ->addHeader([
                Constant::CSSCLASS => implode(' ', [
                    B::TABLE_DARK,
                    B::TEXT_CENTER,
                ]),
            ])
            ->addHeaderRow();
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
    {
        $table->addBodyRow([Constant::CSSCLASS => B::ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CONTENT    => $label,
                Constant::ATTRIBUTES => [
                    Constant::COLSPAN => $colspan,
                    Constant::CSSCLASS   => B::FONT_ITALIC,
                ],
            ]);
    }

    protected function addHeader(Table $table, array $headers): self
    {
        foreach ($headers as $data) {
            if (! is_array($data)) {
                $table->addHeaderCell([Constant::CONTENT => $data]);
            } else {
                if (isset($data['abbr'])) {
                    $strContent = Html::getBalise('abbr', $data[Constant::LABEL], [Constant::TITLE => $data['abbr']]);
                } else {
                    $strContent = $data[Constant::LABEL];
                }

                if ($data['filter'] ?? false) {
                    $strContent = Html::getDiv(
                        $strContent . ' ' . Html::getIcon(
                            I::FITLER,
                            I::SOLID,
                            [
                                Constant::CSSCLASS => 'modal-tooltip ajaxAction',
                                Constant::DATA  => [
                                    Constant::TRIGGER => Constant::CLICK,
                                    Constant::ACTION  => Constant::OPENMODAL,
                                    Constant::TARGET  => $table->attributes[Constant::TARGET],
                                ],
                            ]
                        ),
                        [Constant::CSSCLASS => B::TEXT_NOWRAP]
                    );
                }
                $table->addHeaderCell([Constant::CONTENT => $strContent]);

            }
        }
        return $this;
    }
}
