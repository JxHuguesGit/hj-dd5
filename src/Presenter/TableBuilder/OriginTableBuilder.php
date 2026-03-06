<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
                    ->addBodyCell([C::CONTENT => $url])
                    ->addBodyCell([C::CONTENT => $row->abilities])
                    ->addBodyCell([C::CONTENT => $row->originFeat])
                    ->addBodyCell([C::CONTENT => $row->skills])
                    ->addBodyCell([C::CONTENT => $row->tool]);
            }
        }
        return $table;
    }
}
