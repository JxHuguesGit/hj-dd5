<?php
namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
                        C::CONTENT => Html::getLink($armor->name, $armor->url, B::TEXT_DARK),
                    ])
                    ->addBodyCell([C::CONTENT => $armor->armorClass])
                    ->addBodyCell([
                        C::CONTENT    => $armor->strengthPenalty ?: '-',
                        C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER],
                    ])
                    ->addBodyCell([C::CONTENT => $armor->stealth])
                    ->addBodyCell([
                        C::CONTENT    => $armor->weight,
                        C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END],
                    ])
                    ->addBodyCell([
                        C::CONTENT    => $armor->price,
                        C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END],
                    ]);
            }
        }

        return $table;
    }
}
