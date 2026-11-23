<?php

namespace src\Presenter\TableBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Domain\Entity\InitiativeTracker;
use src\Utils\Html;
use src\Utils\Table;
use src\Utils\UrlGenerator;

class InitiativeTrackerTableBuilder extends AbstractTableBuilder
{

    public function build(mixed $rows, array $params = []): Table
    {
        $headers = [
            [C::LABEL => 'iTCode'],
            [C::LABEL => 'Nom'],
            [C::LABEL => 'Round'],
            [C::LABEL => 'Participant actif'],
            [C::LABEL => 'Actif'],
            C::LABEL => Html::getLink(
                Html::getIcon(I::PLUS),
                UrlGenerator::admin(C::ONG_TIMELINE, C::TIMELINE, '', C::NEW),
                B::TEXT_WHITE
            )
        ];

        $params[C::ID] = 'initiativeTrackerTable';

        $table = $this->createTable(count($headers), $params);
        $this->addHeader($table, $headers);

        foreach ($rows as $row) {
            $this->buildRow($table, $row);
        }

        return $table;
    }

    private function buildRow(Table $table, InitiativeTracker $tracker): void
    {
        $table->addBodyRow([])
            ->addBodyCell([
                C::CONTENT => $tracker->iTCode,
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER]
            ])
            ->addBodyCell([
                C::CONTENT => $tracker->name,
                C::ATTRIBUTES => [C::CSSCLASS => B::BORDER_START]
            ])
            ->addBodyCell([
                C::CONTENT => $tracker->round,
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER . ' ' . B::BORDER_START]
            ])
            ->addBodyCell([
                C::CONTENT => $tracker->currentParticipantId,
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_END . ' ' . B::BORDER_START]

            ])
            ->addBodyCell([
                C::CONTENT => $tracker->active,
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER . ' ' . B::BORDER_START]
            ])
            ->addBodyCell([
                C::CONTENT => Html::getLink(
                    Html::getIcon(I::EDIT),
                    UrlGenerator::admin(
                        C::ONG_TIMELINE,
                        C::TIMELINE,
                        '',
                        C::EDIT,
                        ['combatId' => $tracker->id]
                    ),
                    B::TEXT_DARK
                ) . ' ' .
                    Html::getLink(
                        Html::getIcon(I::EYE),
                        UrlGenerator::admin(
                            C::ONG_TIMELINE,
                            '',
                            '',
                            '',
                            [C::COMBAT => $tracker->iTCode]
                        ),
                        B::TEXT_DARK
                    ),
                C::ATTRIBUTES => [C::CSSCLASS => B::TEXT_CENTER . ' ' . B::BORDER_START]
            ])
        ;
    }
}
