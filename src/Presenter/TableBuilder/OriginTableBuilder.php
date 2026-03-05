<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Presenter\ViewModel\OriginRow;
use src\Utils\Html;
use src\Utils\Table;

class OriginTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [
            L::NAMES,
            L::ABILITIES,
            L::ORIGIN_FEAT,
            L::SKILLS,
            L::TOOL,
        ];
        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            foreach ($group->rows as $row) {
                $url = Html::getLink(
                    $row->name,
                    $row->url,
                    B::TEXT_DARK
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
