<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
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
            [Constant::LABEL => L::NAMES],
            [Constant::LABEL => Constant::VIDE],
            [Constant::LABEL => L::PREQUISITE],
        ];
        if ($this->isAdmin) {
            $headers[] = [Constant::LABEL => Constant::VIDE];
        }
        $params[Constant::ID]     = 'featTable';
        $params[Constant::TARGET] = 'featFilter';

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
                    $this->intermediateLabel = Constant::VIDE;
                    break;
            }
            /** @var FeatGroup $group */
            $this->addGroupRow($table, $url, count($headers));

            foreach ($group->rows as $row) {
                /** @var FeatRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        Constant::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([Constant::CONTENT => $row->originLabel])
                    ->addBodyCell([Constant::CONTENT => $row->prerequisite]);
                if ($this->isAdmin) {
                    $table->addBodyCell([
                        Constant::CONTENT => Html::getLink(
                            Html::getIcon(I::EDIT),
                            UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::FEATS, $row->slug, Constant::EDIT),
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
        $table->addBodyRow([Constant::CLASS => B::ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CONTENT    => $label,
                Constant::ATTRIBUTES => [
                    Constant::CLASS => B::FONT_ITALIC,
                ],
            ])
            ->addBodyCell([
                Constant::CONTENT => $this->intermediateLabel,
            ])
            ->addBodyCell([
                Constant::CONTENT    => Constant::VIDE,
                Constant::ATTRIBUTES => [
                    Constant::COLSPAN => $colspan - 2,
                ],
            ])
        ;
    }
}
