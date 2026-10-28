<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitiativeTrackerWriter;
use src\Utils\Session;

final class ITPrevCombatCharacter
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterService $itcService,
        private InitiativeTrackerWriter $writer,
    ) {}

    public function execute(): array
    {
        $itCode = Session::fromPost('itCode');
        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);
        // On récupère l'ordre du tour
        $orderedQueue = $this->itcService->getTurnOrder($initiativeTracker);
        $actual = $orderedQueue->first();
        // On récupère le précédent personnage à jouer
        $character = $orderedQueue->last();

        $changedFields = [];
        if ($character->initiative<$actual->initiative) {
            if ($initiativeTracker->round==1) {
                // On est dans le cas du premier personnage à jouer du combat, on ne peut pas revenir en arrière.
                return [
                    'round' => 'Round ' . $initiativeTracker->round,
                    'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
                ];
            } else {
                $initiativeTracker->round--;
                $changedFields[] = F::ROUND;
            }
        }
        $initiativeTracker->currentParticipantId = $character->id;
        $changedFields[] = F::CURRENTPARTICIPANTID;

        // On met à jour
        $this->writer->updatePartial($initiativeTracker, $changedFields);

        return [
            'round' => 'Round ' . $initiativeTracker->round,
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }
}
