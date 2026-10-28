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

final class ITRmvCharacterToCombat
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitiativeTrackerWriter $itWriter,
        private InitTrackCharacterWriter $itcWriter,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterService $itcService
    ) {}

    public function execute(): array
    {
        $itCharacterId = (int) Session::fromPost('combatantId');
        // On récupère le personnage associé
        $character = $this->itcReader->itCharacterById($itCharacterId);

        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerById($character->initiativeTrackerId);

        if ($initiativeTracker->currentParticipantId == $character->id) {
            // On récupère l'ordre du tour
            $orderedQueue = $this->itcService->getTurnOrder($initiativeTracker);
            $nextCharacter = $orderedQueue->slice(1, 1)->first();
            $initiativeTracker->currentParticipantId = $nextCharacter->id;
            $this->itWriter->updatePartial($initiativeTracker, [F::CURRENTPARTICIPANTID]);
        }

        // On met à jour
        if ('player'===$character->characterType) {
            $character->active = 0;
            $this->itcWriter->updatePartial($character, [F::ACTIVE]);
        } else {
            $this->itcWriter->delete($character);
        }

        $returned = [
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];

        if ('player' === $character->characterType) {
            $returned['aside'] = $this->itcService->buildAsidePartyMember($character);
        }

        return $returned;
    }


}
