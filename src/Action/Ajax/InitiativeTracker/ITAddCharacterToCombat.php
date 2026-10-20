<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Domain\Entity;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;

final class ITAddCharacterToCombat extends Entity
{
    public function __construct(
        private int $itCharacterId,
        private string $itCode,
        private InitTrackCharacterReader $readerITChar,
        private InitiativeTrackerReader $readerIT,
        private InitTrackCharacterWriter $writerITChar,
    ) {}

    public function execute(): array
    {
        // On récupère la table associée
        $initiativeTracker = $this->readerIT->initiativeTrackerByCode($this->itCode);
        // On récupère le personnage associé
        $character = $this->readerITChar->itCharacterById($this->itCharacterId);
        // On met à jour
        $character->initiativeTrackerId = $initiativeTracker->id;
        $character->active = 1;
        $this->writerITChar->updatePartial($character, [F::ACTIVE]);

        // On formate et on retourne l'affichage central
        // TODO

        return [
            'status' => 'warning',
            'panel'  => ''
        ];
    }


}
