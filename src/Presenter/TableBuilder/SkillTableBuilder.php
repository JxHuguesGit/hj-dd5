<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SkillGroup;
use src\Presenter\ViewModel\SkillRow;
use src\Utils\Html;
use src\Utils\Table;

class SkillTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [L::NAMES, L::DESCRIPTION, 'Sous-compétences'];
        $table   = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($groups as $group) {
            /** @var SkillGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $row) {
                /** @var SkillRow $row */
                $table->addBodyRow([])
                    ->addBodyCell([
                        C::CONTENT => Html::getLink($row->name, $row->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([C::CONTENT => $row->description])
                    ->addBodyCell([C::CONTENT => $row->subSkills]);
            }
        }

        return $table;
    }
}
