<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Presenter\ViewModel\OriginRow;
use src\Utils\Html;
use src\Utils\Table;

class OriginTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [
            Language::LG_NAMES,
            Language::LG_ABILITIES,
            Language::LG_ORIGIN_FEAT,
            Language::LG_SKILLS,
            Language::LG_TOOL
        ];
        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            foreach ($group->rows as $row) {
                $url = Html::getLink(
                    $row->name,
                    $row->url,
                    Bootstrap::CSS_TEXT_DARK
                );
                /** @var OriginRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => $url])
                    ->addBodyCell([Constant::CST_CONTENT => $row->abilities])
                    ->addBodyCell([Constant::CST_CONTENT => $row->originFeat])
                    ->addBodyCell([Constant::CST_CONTENT => $row->skills])
                    ->addBodyCell([Constant::CST_CONTENT => $row->tool]);
            }
        }
        return $table;
    }
}
