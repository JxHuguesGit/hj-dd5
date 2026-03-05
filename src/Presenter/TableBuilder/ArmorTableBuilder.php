<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
use src\Domain\Entity\Armor;
use src\Presenter\ViewModel\ArmorGroup;
use src\Utils\Html;
use src\Utils\Table;

class ArmorTableBuilder extends AbstractTableBuilder
{
    public function build(iterable $groups, array $params = []): Table
    {
        $headers = [
            L::NAMES,
            L::CA,
            L::FORCE,
            L::STEALTH,
            L::WEIGHT,
            L::PRICE,
        ];

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        // Groups
        foreach ($groups as $group) {
            /** @var ArmorGroup $group */
            $this->addGroupRow($table, $group->label, count($headers));

            foreach ($group->rows as $armor) {
                /** @var Armor $armor */
                $table->addBodyRow([])
                    ->addBodyCell([
                        Constant::CONTENT => Html::getLink($armor->name, $armor->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([Constant::CONTENT => $armor->armorClass])
                    ->addBodyCell([
                        Constant::CONTENT    => $armor->strengthPenalty ?: '-',
                        Constant::ATTRIBUTES => [Constant::CSSCLASS => B::TEXT_CENTER],
                    ])
                    ->addBodyCell([Constant::CONTENT => $armor->stealth])
                    ->addBodyCell([
                        Constant::CONTENT    => $armor->weight,
                        Constant::ATTRIBUTES => [Constant::CSSCLASS => B::TEXT_END],
                    ])
                    ->addBodyCell([
                        Constant::CONTENT    => $armor->price,
                        Constant::ATTRIBUTES => [Constant::CSSCLASS => B::TEXT_END],
                    ]);
            }
        }

        return $table;
    }
}
