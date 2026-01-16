<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Table;
use src\Constant\Language;
use src\Utils\Html;

class ItemTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $rows, array $params = []): Table
    {
        $table = $this->createTable(3, $params);

        // Headers
        foreach ([Language::LG_GEAR, Language::LG_WEIGHT, Language::LG_PRICE] as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($rows as $item) {
            /** @var DomainItem $item */
            $table->addBodyRow([])
                ->addBodyCell([Constant::CST_CONTENT => Html::getLink($item->name, $item->url, Bootstrap::CSS_TEXT_DARK)])
                ->addBodyCell([Constant::CST_CONTENT => $item->weight, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]])
                ->addBodyCell([Constant::CST_CONTENT => $item->price, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]]);
        }

        return $table;
    }
}
