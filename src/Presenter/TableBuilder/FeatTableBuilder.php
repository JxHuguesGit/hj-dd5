<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Language;
use src\Utils\UrlGenerator;

class FeatTableBuilder extends AbstractTableBuilder
{
    public function __construct(
        private bool $isAdmin=false
    ) {}

    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [Language::LG_FEATS, Language::LG_ORIGIN, Language::LG_PREQUISITE];
        if ($this->isAdmin) {
            $headers[] = Constant::CST_VIDE;
        }

        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            $url = Html::getLink(
                $group->label,
                UrlGenerator::feats($group->slug),
                Bootstrap::CSS_TEXT_WHITE
            ) . $group->extraPrerequis;
            /** @var FeatGroup $group */
            $this->addGroupRow($table, $url, count($headers));

            foreach ($group->rows as $row) {
                /** @var FeatRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $row->originLabel])
                    ->addBodyCell([Constant::CST_CONTENT => $row->prerequisite]);
                if ($this->isAdmin) {
                    $table->addBodyCell([
                        Constant::CST_CONTENT => Html::getLink(
                            Html::getIcon(Icon::IEDIT),
                            UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::FEATS, $row->slug, Constant::EDIT),
                            Bootstrap::CSS_TEXT_DARK
                        )
                    ]);
                }
            }
        }

        return $table;
    }
}
