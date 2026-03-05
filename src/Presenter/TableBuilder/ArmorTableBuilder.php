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
                        Constant::CST_CONTENT => Html::getLink($armor->name, $armor->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->armorClass])
                    ->addBodyCell([
                        Constant::CST_CONTENT    => $armor->strengthPenalty ?: '-',
                        Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_CENTER],
                    ])
                    ->addBodyCell([Constant::CST_CONTENT => $armor->stealth])
                    ->addBodyCell([
                        Constant::CST_CONTENT    => $armor->weight,
                        Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_END],
                    ])
                    ->addBodyCell([
                        Constant::CST_CONTENT    => $armor->price,
                        Constant::CST_ATTRIBUTES => [Constant::CST_CLASS => B::TEXT_END],
                    ]);
            }
        }

        return $table;
    }
}
