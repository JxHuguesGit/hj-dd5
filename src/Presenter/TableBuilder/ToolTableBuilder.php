<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Tool as DomainTool;
use src\Presenter\ViewModel\ToolGroup;
use src\Utils\Table;
use src\Utils\Utils;

class ToolTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groupedTools, array $params=[]): Table
    {
        $withMarginTop = $params[Bootstrap::CSS_WITH_MRGNTOP] ?? true;

        $table = new Table();
        $table->setTable([Constant::CST_CLASS => implode(' ', [
                Bootstrap::CSS_TABLE_SM,
                Bootstrap::CSS_TABLE_STRIPED,
                $withMarginTop ? Bootstrap::CSS_MT5 : ''
            ])])
            ->addHeader([Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_TABLE_DARK, Bootstrap::CSS_TEXT_CENTER])])
            ->addHeaderRow();
        $this->addHeaders($table);

        foreach ($groupedTools as $group) {
            $this->addGroupRow($table, $group);

            // Outils de ce type
            foreach ($group->tools as $tool) {
                /** @var DomainTool $tool */
                $this->addToolRow($table, $tool);
            }
        }

        return $table;
    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_TOOLS,
            Language::LG_WEIGHT,
            Language::LG_PRICE,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addGroupRow(Table $table, ToolGroup $toolGroup): void
    {
        // Ligne de rupture
        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT => $toolGroup->label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => 3,
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                ]
            ]);
    }

    private function addToolRow(Table $table, DomainTool $tool): void
    {
        $table->addBodyRow([])
            ->addBodyCell([Constant::CST_CONTENT => $tool->name])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrWeight($tool->weight),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrPrice($tool->goldPrice),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ]);
    }
}
