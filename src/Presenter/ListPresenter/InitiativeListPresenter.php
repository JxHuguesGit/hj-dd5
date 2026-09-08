<?php

namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Domain\Entity\Combat;
use src\Presenter\ViewModel\InitiativeRow;

final class InitiativeListPresenter
{
    public function present(
        Combat $combat,
        iterable $participants
    ): Collection {
        $rows = new Collection();

        foreach ($participants as $participant) {
            $rows->add(new InitiativeRow(
                name: $participant->name,
                initiative: $participant->initiative,
                active: $participant->id === $combat->currentParticipantId,
                type: 'pnj',//$participant->type
            ));
        }

        return $rows;
    }
}
