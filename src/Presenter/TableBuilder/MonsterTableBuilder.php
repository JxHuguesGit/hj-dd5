<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class MonsterTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $monsters, array $params = []): Table
    {
        $createLink = Html::getLink(
            Html::getIcon(I::PLUS),
            UrlGenerator::admin(C::ONG_COMPENDIUM, C::TAB_MONSTERS, '', C::NEW ),
            B::TEXT_WHITE
        );
        $headers = [
            [C::LABEL => L::MONSTER],
            [C::LABEL => L::FP, C::CSSCLASS => B::COL_1],
            [C::LABEL => L::CREATURE_TYPE, C::CSSCLASS => B::COL_2],
            [C::LABEL => L::CA, C::CSSCLASS => B::COL_1],
            [C::LABEL => L::PV, C::CSSCLASS => B::COL_1],
            [C::LABEL => L::REFERENCE, C::CSSCLASS => B::COL_2],
            [C::LABEL => $createLink, C::CSSCLASS => B::COL_1],
        ];

        $params[C::ID] = 'monsterFilter';
        $table                    = $this->createTable(count($headers), $params);

        foreach ($headers as $data) {
            $table->addHeaderCell([
                C::CONTENT    => $data[C::LABEL],
                C::ATTRIBUTES => [C::CSSCLASS => $data[C::CSSCLASS] ?? ''],
            ]);
        }

        foreach ($monsters as $monster) {
            /** @var MonsterRow $row */
            $table->addBodyRow([])
                ->addBodyCell([C::CONTENT => $monster->name])
                ->addBodyCell([C::CONTENT => $monster->cr, C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER]])
                ->addBodyCell([C::CONTENT => $monster->type])
                ->addBodyCell([C::CONTENT => $monster->ca, C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER]])
                ->addBodyCell([C::CONTENT => $monster->hp, C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END]])
                ->addBodyCell([C::CONTENT => $monster->reference])
                ->addBodyCell([
                    C::CONTENT    => Html::getLink(
                        Html::getIcon(I::EDIT),
                        UrlGenerator::admin(C::ONG_COMPENDIUM, C::TAB_MONSTERS, $monster->ukTag ?? '', C::EDIT),
                        B::TEXT_DARK
                    ),
                    C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER . ' ' . B::COL_1],
                ]);
        }

        $table->addFooter([
            C::CSSCLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                C::CONTENT    => Html::getDiv(
                    Html::getIcon(I::CIRCLEPLUS),
                    [
                        C::CSSCLASS => C::AJAXACTION . ' cursor-pointer',
                        C::DATA  => [
                            C::TRIGGER => C::CLICK,
                            C::ACTION  => 'loadMoreMonsters',
                        ],
                    ]
                ),
                C::ATTRIBUTES => [C::COLSPAN => count($headers)],
            ]);

        return $table;
    }
}
