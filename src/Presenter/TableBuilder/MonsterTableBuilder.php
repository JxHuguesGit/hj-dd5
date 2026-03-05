<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class MonsterTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $monsters, array $params = []): Table
    {
        $createLink = Html::getLink(
            Html::getIcon(Icon::IPLUS),
            UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::TAB_MONSTERS, '', Constant::NEW ),
            B::TEXT_WHITE
        );
        $headers = [
            [Constant::CST_LABEL => Language::LG_MONSTER],
            [Constant::CST_LABEL => Language::LG_FP, Constant::CST_CLASS => B::COL_1],
            [Constant::CST_LABEL => Language::LG_CREATURE_TYPE, Constant::CST_CLASS => B::COL_2],
            [Constant::CST_LABEL => Language::LG_CA, Constant::CST_CLASS => B::COL_1],
            [Constant::CST_LABEL => Language::LG_PV, Constant::CST_CLASS => B::COL_1],
            [Constant::CST_LABEL => Language::LG_REFERENCE, Constant::CST_CLASS => B::COL_2],
            [Constant::CST_LABEL => $createLink, Constant::CST_CLASS => B::COL_1],
        ];

        $params[Constant::CST_ID] = 'monsterFilter';
        $table                    = $this->createTable(count($headers), $params);

        foreach ($headers as $data) {
            $table->addHeaderCell([
                Constant::CST_CONTENT    => $data[Constant::CST_LABEL],
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => $data[Constant::CST_CLASS] ?? ''],
            ]);
        }

        foreach ($monsters as $monster) {
            /** @var MonsterRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => $monster->name])
                ->addBodyCell([Constant::CST_CONTENT => $monster->cr, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER]])
                ->addBodyCell([Constant::CST_CONTENT => $monster->type])
                ->addBodyCell([Constant::CST_CONTENT => $monster->ca, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER]])
                ->addBodyCell([Constant::CST_CONTENT => $monster->hp, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_END]])
                ->addBodyCell([Constant::CST_CONTENT => $monster->reference])
                ->addBodyCell([
                    Constant::CST_CONTENT    => Html::getLink(
                        Html::getIcon(Icon::IEDIT),
                        UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::TAB_MONSTERS, $monster->ukTag ?? '', Constant::EDIT),
                        B::TEXT_DARK
                    ),
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER . ' ' . B::COL_1],
                ]);
        }

        $table->addFooter([
            Constant::CST_CLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                Constant::CST_CONTENT    => Html::getDiv(
                    Html::getIcon(Icon::ICIRCLEPLUS),
                    [
                        Constant::CST_CLASS => Constant::CST_AJAXACTION . ' cursor-pointer',
                        Constant::CST_DATA  => [
                            Constant::CST_TRIGGER => Constant::CST_CLICK,
                            Constant::CST_ACTION  => 'loadMoreMonsters',
                        ],
                    ]
                ),
                Constant::CST_ATTRIBUTES => [Constant::CST_COLSPAN => count($headers)],
            ]);

        return $table;
    }
}
