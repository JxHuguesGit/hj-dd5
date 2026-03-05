<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpellRow;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;
use src\Utils\Table;

class SpellTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $headers = [
            [Constant::CST_LABEL => L::NAMES],
            [Constant::CST_LABEL => L::LEVEL, 'filter' => true],
            [Constant::CST_LABEL => L::SCHOOL, 'filter' => true],
            [Constant::CST_LABEL => L::CLASSES, 'filter' => true],
            [Constant::CST_LABEL => 'TI', 'abbr' => L::INCTIME],
            [Constant::CST_LABEL => L::RANGE],
            [Constant::CST_LABEL => L::DURATION],
            [Constant::CST_LABEL => 'V,S,M', 'abbr' => L::COMPONENTS],
        ];

        $params[Constant::CST_ID]     = 'spellTable';
        $params[Constant::CST_TARGET] = 'spellFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            /** @var SpellRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK)])
                ->addBodyCell([
                    Constant::CST_CONTENT    => $row->niveau,
                    Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER],
                ])
                ->addBodyCell([Constant::CST_CONTENT => $row->ecole])
                ->addBodyCell([Constant::CST_CONTENT => SpellFormatter::formatClasses($row->classes, false)])
                ->addBodyCell([Constant::CST_CONTENT => SpellFormatter::formatIncantation($row->tpsInc, $row->rituel)])
                ->addBodyCell([Constant::CST_CONTENT => SpellFormatter::formatPortee($row->portee)])
                ->addBodyCell([Constant::CST_CONTENT => SpellFormatter::formatDuree($row->duree, $row->concentration)])
                ->addBodyCell([Constant::CST_CONTENT => SpellFormatter::formatComposantes($row->composantes, $row->composanteMaterielle, false)])
            ;
        }

        $table->addFooter([
            Constant::CST_CLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                Constant::CST_CONTENT    => '<div class="ajaxAction" data-trigger="click" data-action="loadMoreSpells" style="cursor:pointer;"><i class="fa-solid fa-circle-plus"></i></div>',
                Constant::CST_ATTRIBUTES => [Constant::CST_COLSPAN => 8],
            ]);

        return $table;
    }
}
