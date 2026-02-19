<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillRow;
use src\Utils\Html;
use src\Utils\Table;

class SkillTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [Language::LG_NAMES, Language::LG_DESCRIPTION, 'Sous-compétences'];
        $table = $this->createTable(count($headers), $params);

        foreach ($headers as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            /** @var SkillGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var SkillRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)
                    ])
                    ->addBodyCell([Constant::CST_CONTENT => $row->description])
                    ->addBodyCell([Constant::CST_CONTENT => $row->subSkills]);
            }
        }

        return $table;
    }
}
