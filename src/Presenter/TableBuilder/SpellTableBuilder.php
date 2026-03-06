<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
            [C::LABEL => L::NAMES],
            [C::LABEL => L::LEVEL, 'filter' => true],
            [C::LABEL => L::SCHOOL, 'filter' => true],
            [C::LABEL => L::CLASSES, 'filter' => true],
            [C::LABEL => 'TI', 'abbr' => L::INCTIME],
            [C::LABEL => L::RANGE],
            [C::LABEL => L::DURATION],
            [C::LABEL => 'V,S,M', 'abbr' => L::COMPONENTS],
        ];

        $params[C::ID]     = 'spellTable';
        $params[C::TARGET] = 'spellFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            /** @var SpellRow $row */
            $table->addBodyRow([])
                ->addBodyCell([C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK)])
                ->addBodyCell([
                    C::CONTENT    => $row->niveau,
                    C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER],
                ])
                ->addBodyCell([C::CONTENT => $row->ecole])
                ->addBodyCell([C::CONTENT => SpellFormatter::formatClasses($row->classes, false)])
                ->addBodyCell([C::CONTENT => SpellFormatter::formatIncantation($row->tpsInc, $row->rituel)])
                ->addBodyCell([C::CONTENT => SpellFormatter::formatPortee($row->portee)])
                ->addBodyCell([C::CONTENT => SpellFormatter::formatDuree($row->duree, $row->concentration)])
                ->addBodyCell([C::CONTENT => SpellFormatter::formatComposantes($row->composantes, $row->composanteMaterielle, false)])
            ;
        }

        $table->addFooter([
            C::CSSCLASS => implode(' ', [
                B::TABLE_DARK,
                B::TEXT_CENTER,
            ]),
        ])
            ->addFootRow()
            ->addFootCell([
                C::CONTENT    => '<div class="ajaxAction" data-trigger="click" data-action="loadMoreSpells" style="cursor:pointer;"><i class="fa-solid fa-circle-plus"></i></div>',
                C::ATTRIBUTES => [C::COLSPAN => 8],
            ]);

        return $table;
    }
}
