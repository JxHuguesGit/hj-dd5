<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitiativeTrackerWriter;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITNextCombatCharacter
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterService $itcService,
        private InitiativeTrackerWriter $itWriter,
        private InitTrackCharacterWriter $itcWriter,
    ) {}

    public function execute(): array
    {
        $itCode = Session::fromPost('itCode');
        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);
        // On récupère l'ordre du tour
        $orderedQueue = $this->itcService->getTurnOrder($initiativeTracker);
        $actual = $orderedQueue->first();
        // On récupère le prochain personnage à jouer
        $character = $orderedQueue->slice(1, 1)->first();

        $initiativeTracker->currentParticipantId = $character->id;
        $changedFields = [F::CURRENTPARTICIPANTID];
        // Si on change de round, on doit incrémenter.
        if ($character->initiative > $actual->initiative) {
            $initiativeTracker->round++;
            $changedFields[] = F::ROUND;
        }

        // On met à jour
        $this->itWriter->updatePartial($initiativeTracker, $changedFields);

        $character->reactionAvailable = 1;
        $character->readyActive = 0;
        $this->itcWriter->updatePartial($character, [F::REACTIONAVAIL, F::READYACTIVE]);

        return [
            'round' => 'Round ' . $initiativeTracker->round,
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }
}
