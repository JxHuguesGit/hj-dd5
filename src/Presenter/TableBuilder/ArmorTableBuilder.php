<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Armor as DomainArmor;
use src\Presenter\ViewModel\ArmorGroup;
use src\Utils\Table;
use src\Utils\Utils;

class ArmorTableBuilder implements TableBuilderInterface
{
    public function build(iterable $groupedArmors, array $params=[]): Table
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

        foreach ($groupedArmors as $group) {
            $this->addGroupRow($table, $group);

            foreach ($group->armors as $armor) {
                /** @var DomainArmor $armor */
                $this->addArmorRow($table, $armor);
            }
        }

        return $table;
    }

    private function addHeaders(Table $table): void
    {
        $headerLabels = [
            Language::LG_ARMORS,
            Language::LG_CA,
            Language::LG_FORCE,
            Language::LG_STEALTH,
            Language::LG_WEIGHT,
            Language::LG_PRICE,
        ];
        foreach ($headerLabels as $label) {
            $table->addHeaderCell([Constant::CST_CONTENT => $label]);
        }
    }

    private function addGroupRow(Table $table, ArmorGroup $armorGroup): void
    {
        $table->addBodyRow([Constant::CST_CLASS => Bootstrap::CSS_ROW_DARK_STRIPED])
            ->addBodyCell([
                Constant::CST_CONTENT => $armorGroup->label,
                Constant::CST_ATTRIBUTES => [
                    Constant::CST_COLSPAN => 6,
                    Constant::CST_CLASS => Bootstrap::CSS_FONT_ITALIC
                ]
            ]);
    }

    private function addArmorRow(Table $table, DomainArmor $armor): void
    {
        $table->addBodyRow([])
            ->addBodyCell([Constant::CST_CONTENT => $armor->name])
            ->addBodyCell([Constant::CST_CONTENT => $armor->displayArmorClass()])
            ->addBodyCell([
                Constant::CST_CONTENT => $armor->strengthPenalty ?: '-',
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_CENTER]
            ])
            ->addBodyCell([Constant::CST_CONTENT => $armor->stealthDisadvantage ? Language::LG_DISADVANTAGE : '-'])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrWeight($armor->weight),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ])
            ->addBodyCell([
                Constant::CST_CONTENT => Utils::getStrPrice($armor->goldPrice),
                Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => Bootstrap::CSS_TEXT_END]
            ]);
    }
}
