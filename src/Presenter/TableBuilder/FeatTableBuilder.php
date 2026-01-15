<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\FeatGroup;
use src\Presenter\ViewModel\FeatRow;
use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Language;
use src\Utils\UrlGenerator;

class FeatTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $table = $this->createTable(3, $params);

        foreach ([Language::LG_FEATS, Language::LG_ORIGIN, Language::LG_PREQUISITE] as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            $url = Html::getLink(
                $group->label,
                UrlGenerator::feats($group->slug),
                Bootstrap::CSS_TEXT_WHITE
            ) . $group->extraPrerequis;
            /** @var FeatGroup $group */
            $this->addGroupRow($table, $url, 3);

            foreach ($group->rows as $row) {
                /** @var FeatRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $row->originLabel])
                    ->addBodyCell([Constant::CST_CONTENT => $row->prerequisite]);
            }
        }

        return $table;
    }
}
