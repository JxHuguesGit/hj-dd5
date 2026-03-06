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

    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [
            [C::LABEL => L::NAMES],
            [C::LABEL => C::VIDE],
            [C::LABEL => L::PREQUISITE],
        ];
        if ($this->isAdmin) {
            $headers[] = [C::LABEL => C::VIDE];
        }
        $params[C::ID]     = 'featTable';
        $params[C::TARGET] = 'featFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            $url = Html::getLink(
                $group->label,
                UrlGenerator::feats($group->slug),
                B::TEXT_WHITE
            ) . $group->extraPrerequis;
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
            $this->addGroupRow($table, $url, count($headers));

            foreach ($group->rows as $row) {
                /** @var FeatRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([C::CONTENT => $row->originLabel])
                    ->addBodyCell([C::CONTENT => $row->prerequisite]);
                if ($this->isAdmin) {
                    $table->addBodyCell([
                        C::CONTENT => Html::getLink(
                            Html::getIcon(I::EDIT),
                            UrlGenerator::admin(C::ONG_COMPENDIUM, C::FEATS, $row->slug, C::EDIT),
                            B::TEXT_DARK
                        ),
                    ]);
                }
            }
        }

        return $table;
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
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
                C::CONTENT    => C::VIDE,
                C::ATTRIBUTES => [
                    C::COLSPAN => $colspan - 2,
                ],
            ])
        ;
    }
}
