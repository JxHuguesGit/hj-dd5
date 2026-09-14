<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class FeatTableBuilder extends AbstractTableBuilder
{
    private string $intermediateLabel = '';

    public function __construct(
        private bool $isAdmin = false
    ) {}

    public function build(object $groups, array $params = []): Table
    {
        $headers = [
            [C::LABEL => L::NAMES, C::CSSCLASS => B::COL_3],
            [C::LABEL => C::VIDE],
            [C::LABEL => L::PREQUISITE, C::CSSCLASS => B::COL_3],
            [C::LABEL => L::SOURCE, C::CSSCLASS => B::COL_2],
        ];
        if ($this->isAdmin) {
            $headers[] = [C::LABEL => C::VIDE, C::CSSCLASS => B::COL_1];
        }
        $params[C::ID]     = 'featTable';
        $params[C::TARGET] = 'featFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            $this->buildGroup($table, $headers, $group);
        }

        return $table;
    }

    private function buildGroup(Table $table, array $headers, FeatGroup $group): void
    {
        $url = Html::getLink(
            $group->label,
            UrlGenerator::feats($group->slug),
            B::TEXT_WHITE
        );
        switch ($group->slug) {
            case '-origin':
                $this->intermediateLabel = L::ORIGINS;
                break;
            case '-general':
                $this->intermediateLabel = L::ABILITIES;
                break;
            default:
                $this->intermediateLabel = C::VIDE;
                break;
        }
        /** @var FeatGroup $group */
        $this->addGroupRowLocal($table, $url, $group->extraPrerequis, count($headers));

        foreach ($group->rows as $row) {
            $this->buildRow($table, $row);
        }
    }

    private function buildRow(Table $table, FeatRow $row): void
    {
        $origins = [];
        foreach ($row->origins as $origin) {
            $origins[] = Html::getLink(
                $origin->name,
                UrlGenerator::origin($origin->slug),
                B::TEXT_DARK
            );
        }
        $abilities = [];
        foreach ($row->abilities as $ability) {
            $abilities[] = $ability->name;
        }

        /** @var FeatRow $row */
        $table->addBodyRow([])
            ->addBodyCell([
                C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ])
            ->addBodyCell([
                C::CONTENT => implode(', ', ($origins == [] ? $abilities : $origins)),
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ])
            ->addBodyCell([
                C::CONTENT => $row->prerequisite,
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ])
            ->addBodyCell([
                C::CONTENT => $row->sourceName,
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_END]
            ]);
        if ($this->isAdmin) {
            $table->addBodyCell([
                C::CONTENT => Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(C::ONG_COMPENDIUM, C::FEATS, $row->id, C::EDIT),
                    B::TEXT_DARK
                ),
            ]);
        }
    }

    protected function addGroupRowLocal(
        Table $table,
        string $label,
        string $preRequis,
        int $colspan
    ): void
    {
        $table->addBodyRow([C::CSSCLASS => B::ROW_DARK_STRIPED])
            ->addBodyCell([
                C::CONTENT    => $label,
                C::ATTRIBUTES => [
                    C::CSSCLASS => B::FONT_ITALIC,
                ],
            ])
            ->addBodyCell([
                C::CONTENT => $this->intermediateLabel,
            ])
            ->addBodyCell([
                C::CONTENT => $preRequis,
            ])
            ->addBodyCell([
                C::CONTENT    => C::VIDE,
                C::ATTRIBUTES => [
                    C::COLSPAN => $colspan - 3,
                ],
            ])
        ;
    }
}
