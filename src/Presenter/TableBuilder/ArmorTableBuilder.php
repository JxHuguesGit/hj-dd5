<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Domain\Entity\Armor;
use src\Presenter\ViewModel\ArmorGroup;
use src\Utils\Table;
use src\Constant\Language;
use src\Utils\Html;

class ArmorTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [Language::LG_ARMORS, Language::LG_CA, Language::LG_FORCE, Language::LG_STEALTH, Language::LG_WEIGHT, Language::LG_PRICE];

        $table = $this->createTable(count($headers), $params);

        // Headers
        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        // Groups
        foreach ($groups as $group) {
            /** @var ArmorGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $armor) {
                /** @var Armor $armor */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($armor->name, $armor->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->armorClass])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->strengthPenalty ?: '-', Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->stealth])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->weight, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->price, Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]]);
            }
        }

        return $table;
    }
}
