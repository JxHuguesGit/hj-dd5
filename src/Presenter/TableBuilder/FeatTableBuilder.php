<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
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
            [Constant::CST_LABEL => Language::LG_NAMES, 'filter' => true],
            [Constant::CST_LABEL => Constant::CST_VIDE],
            [Constant::CST_LABEL => Language::LG_PREQUISITE],
        ];
        if ($this->isAdmin) {
            $headers[] = [Constant::CST_LABEL => Constant::CST_VIDE];
        }
        $params[Constant::CST_ID]     = 'featTable';
        $params[Constant::CST_TARGET] = 'featFilter';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            $url = Html::getLink(
                $group->label,
                UrlGenerator::feats($group->slug),
                Bootstrap::CSS_TEXT_WHITE
            ) . $group->extraPrerequis;
            switch ($group->slug) {
                case '-origin':
                    $this->intermediateLabel = Language::LG_ORIGINS;
                    break;
                case '-general':
                    $this->intermediateLabel = Language::LG_ABILITIES;
                    break;
                default:
                    $this->intermediateLabel = Constant::CST_VIDE;
                    break;
            }
            /** @var FeatGroup $group */
            $this->addGroupRow($table, $url, count($headers));

            foreach ($group->rows as $row) {
                /** @var FeatRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK),
                    ])
                    ->addBodyCell([Constant::CST_CONTENT => $row->originLabel])
                    ->addBodyCell([Constant::CST_CONTENT => $row->prerequisite]);
                if ($this->isAdmin) {
                    $table->addBodyCell([
                        Constant::CST_CONTENT => Html::getLink(
                            Html::getIcon(Icon::IEDIT),
                            UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::FEATS, $row->slug, Constant::EDIT),
                            Bootstrap::CSS_TEXT_DARK
                        ),
                    ]);
                }
            }
        }

        return $table;
    }

    protected function addGroupRow(Table $table, string $label, int $colspan): void
    {
        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT    => $label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC,
                ],
            ])
            ->addBodyCell([
                Constant::CST_CONTENT => $this->intermediateLabel,
            ])
            ->addBodyCell([
                Constant::CST_CONTENT    => Constant::CST_VIDE,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => $colspan - 2,
                ],
            ])
        ;
    }
}
