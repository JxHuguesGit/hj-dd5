<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Presenter\ViewModel\OriginRow;
use src\Utils\Table;
use src\Utils\Html;
use src\Constant\Constant;
use src\Constant\Language;
use src\Utils\UrlGenerator;

class OriginTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $table = $this->createTable(5, $params);

        foreach ([Language::LG_ORIGINS, Language::LG_ABILITIES, Language::LG_ORIGIN_FEAT, Language::LG_SKILLS, Language::LG_TOOLS] as $label) {
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
