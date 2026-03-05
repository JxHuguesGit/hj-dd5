<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
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
            UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::TAB_MONSTERS, '', Constant::NEW ),
            B::TEXT_WHITE
        );
        $headers = [
            [Constant::LABEL => L::MONSTER],
            [Constant::LABEL => L::FP, Constant::CLASS => B::COL_1],
            [Constant::LABEL => L::CREATURE_TYPE, Constant::CLASS => B::COL_2],
            [Constant::LABEL => L::CA, Constant::CLASS => B::COL_1],
            [Constant::LABEL => L::PV, Constant::CLASS => B::COL_1],
            [Constant::LABEL => L::REFERENCE, Constant::CLASS => B::COL_2],
            [Constant::LABEL => $createLink, Constant::CLASS => B::COL_1],
        ];

        $params[Constant::ID] = 'monsterFilter';
        $table                    = $this->createTable(count($headers), $params);

        foreach ($headers as $data) {
            $table->addHeaderCell([
                Constant::CONTENT    => $data[Constant::LABEL],
                Constant::ATTRIBUTES => [Constant::CLASS => $data[Constant::CLASS] ?? ''],
            ]);
        }

        foreach ($monsters as $monster) {
            /** @var MonsterRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CONTENT => $monster->name])
                ->addBodyCell([Constant::CONTENT => $monster->cr, Constant::ATTRIBUTES => [Constant::CLASS => B::TEXT_CENTER]])
                ->addBodyCell([Constant::CONTENT => $monster->type])
                ->addBodyCell([Constant::CONTENT => $monster->ca, Constant::ATTRIBUTES => [Constant::CLASS => B::TEXT_CENTER]])
                ->addBodyCell([Constant::CONTENT => $monster->hp, Constant::ATTRIBUTES => [Constant::CLASS => B::TEXT_END]])
                ->addBodyCell([Constant::CONTENT => $monster->reference])
                ->addBodyCell([
                    Constant::CONTENT    => Html::getLink(
                        Html::getIcon(I::EDIT),
                        UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::TAB_MONSTERS, $monster->ukTag ?? '', Constant::EDIT),
                        B::TEXT_DARK
                    ),
                    Constant::ATTRIBUTES => [Constant::CLASS => B::TEXT_CENTER . ' ' . B::COL_1],
                ]);
        }

        $table->addFooter([
            Constant::CLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                Constant::CONTENT    => Html::getDiv(
                    Html::getIcon(I::CIRCLEPLUS),
                    [
                        Constant::CLASS => Constant::AJAXACTION . ' cursor-pointer',
                        Constant::DATA  => [
                            Constant::TRIGGER => Constant::CLICK,
                            Constant::ACTION  => 'loadMoreMonsters',
                        ],
                    ]
                ),
                Constant::ATTRIBUTES => [Constant::COLSPAN => count($headers)],
            ]);

        return $table;
    }
}
