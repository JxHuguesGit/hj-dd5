<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Domain\Criteria\SpellCriteria;
use src\Presenter\ViewModel\SpellRow;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class SpellTableBuilder extends AbstractTableBuilder
{
    public function __construct(
        private bool $isAdmin = false
    ) {}

    public function build(mixed $rows, array $params = []): Table
    {
        $headers = [
            [C::LABEL => L::NAMES],
            [C::LABEL => L::LEVEL, 'filter' => true],
            [C::LABEL => L::SCHOOL, 'filter' => true],
            //[C::LABEL => L::CLASSES, 'filter' => true],
            [C::LABEL => 'TI', 'abbr' => L::INCTIME],
            [C::LABEL => L::RANGE],
            [C::LABEL => L::DURATION],
            [C::LABEL => 'V,S,M', 'abbr' => L::COMPONENTS],
        ];
        if ($this->isAdmin) {
            $headers[] = [
                C::LABEL => Html::getLink(
                    Html::getIcon(I::PLUS),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::SPELLS, '', C::NEW),
                    B::TEXT_WHITE
                )
            ];
        }
        $params[C::ID]     = 'spellTable';
        $params[C::TARGET] = C::SPELL_FILTER;

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            /** @var SpellRow $row */
            $this->buildRow($table, $row);
        }

        $this->addFooter($table);

        return $table;
    }

    private function buildRow(Table $table, SpellRow $row): void
    {
        $table->addBodyRow([])
            ->addBodyCell([C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK)])
            ->addBodyCell([
                C::CONTENT    => $row->niveau,
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER],
            ])
            ->addBodyCell([C::CONTENT => $row->ecole])
            //->addBodyCell([C::CONTENT => SpellFormatter::formatClasses($row->classes, false)])
            ->addBodyCell([C::CONTENT => SpellFormatter::formatIncantation($row->tpsInc, $row->rituel)])
            ->addBodyCell([C::CONTENT => $row->portee])
            ->addBodyCell([C::CONTENT => SpellFormatter::formatDuree($row->duree, $row->concentration)])
            ->addBodyCell([C::CONTENT => SpellFormatter::formatComposantes($row->composantes, $row->composanteMaterielle, false)])
        ;
        if ($this->isAdmin) {
            $table->addBodyCell([
                C::CONTENT => Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::SPELLS, $row->id, C::EDIT),
                    B::TEXT_DARK
                ),
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_START]
            ]);
        }
    }

    private function addFooter(Table $table): void
    {
        $colCount = $table->attributes['colCount'];
        if ($this->isAdmin) {
            ++$colCount;
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
                        C::CSSCLASS => 'ajaxAction spell-load-more',
                        C::DATA     => [
                            C::TRIGGER => 'click',
                            C::ACTION  => 'loadMoreSpells',
                            'next-page' => 2,
                            'per-page'  => SpellCriteria::DEFAULT_PAGE_SIZE,
                            C::VIEW     => 'table',
                        ],
                        C::STYLE    => 'cursor:pointer;'
                    ]
                ),
                C::ATTRIBUTES => [C::COLSPAN => $colCount],
            ]);
    }
}
