<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillRow;
use src\Utils\Table;
use src\Constant\Language;
use src\Utils\Html;

class SkillTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $table = $this->createTable(3, $params);

        foreach ([Language::LG_SKILLS, Language::LG_DESCRIPTION, 'Sous-compétences'] as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }

        foreach ($groups as $group) {
            /** @var SkillGroup $group */
            $this->addGroupRow($table, $group->label, 3);

            foreach ($group->rows as $row) {
                /** @var SkillRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([Constant::CST_CONTENT => Html::getLink($row->name, $row->url, Bootstrap::CSS_TEXT_DARK)])
                    ->addBodyCell([Constant::CST_CONTENT => $row->description])
                    ->addBodyCell([Constant::CST_CONTENT => $row->subSkills]);
            }
        }

        return $table;
    }
}
