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
            [Constant::LABEL => L::NAMES],
            [Constant::LABEL => L::LEVEL, 'filter' => true],
            [Constant::LABEL => L::SCHOOL, 'filter' => true],
            [Constant::LABEL => L::CLASSES, 'filter' => true],
            [Constant::LABEL => 'TI', 'abbr' => L::INCTIME],
            [Constant::LABEL => L::RANGE],
            [Constant::LABEL => L::DURATION],
            [Constant::LABEL => 'V,S,M', 'abbr' => L::COMPONENTS],
        ];

        $params[Constant::ID]     = 'spellTable';
        $params[Constant::TARGET] = 'spellFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            /** @var SpellRow $row */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK)])
                ->addBodyCell([
                    Constant::CONTENT    => $row->niveau,
                    Constant::ATTRIBUTES => [Constant::CSSCLASS => B::TEXT_CENTER],
                ])
                ->addBodyCell([Constant::CONTENT => $row->ecole])
                ->addBodyCell([Constant::CONTENT => SpellFormatter::formatClasses($row->classes, false)])
                ->addBodyCell([Constant::CONTENT => SpellFormatter::formatIncantation($row->tpsInc, $row->rituel)])
                ->addBodyCell([Constant::CONTENT => SpellFormatter::formatPortee($row->portee)])
                ->addBodyCell([Constant::CONTENT => SpellFormatter::formatDuree($row->duree, $row->concentration)])
                ->addBodyCell([Constant::CONTENT => SpellFormatter::formatComposantes($row->composantes, $row->composanteMaterielle, false)])
            ;
        }

        $table->addFooter([
            Constant::CSSCLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                Constant::CONTENT    => '<div class="ajaxAction" data-trigger="click" data-action="loadMoreSpells" style="cursor:pointer;"><i class="fa-solid fa-circle-plus"></i></div>',
                Constant::ATTRIBUTES => [Constant::COLSPAN => 8],
            ]);

        return $table;
    }
}
