<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITAddCharacterToCombat
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterWriter $writer,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterService $itcService
    ) {}

    public function execute(): array
    {
        $itCharacterId = (int) Session::fromPost('character_id');
        $itCode = Session::fromPost(F::ITID);

        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);
        // On récupère le personnage associé
        $character = $this->itcReader->itCharacterById($itCharacterId);
        // On met à jour
        $character->initiativeTrackerId = $initiativeTracker->id;
        $character->active = 1;
        $this->writer->updatePartial($character, [F::ACTIVE, F::ITID]);

        return [
            'asideCard' => $this->itcService->buildAsidePartyMember($character),
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }


}
