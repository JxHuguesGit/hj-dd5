<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitiativeTrackerWriter;
use src\Utils\Session;

final class ITStartEndCombat
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterService $itcService,
        private InitiativeTrackerWriter $writer,
        private string $type,
    ) {}

    public function execute(): array
    {
        $itCode = Session::fromPost(F::ITID);

        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);

        if ($this->type === 'endCombat') {
            $initiativeTracker->active = 0;
            $initiativeTracker->round  = 0;
            $initiativeTracker->currentParticipantId = 0;
        } else {
            $initiativeTracker->active = 1;
            $initiativeTracker->round  = 1;
            $initiativeTracker->currentParticipantId = $this->itcService->rollInitiative($initiativeTracker->id);
        }

        $changedFields = [F::ACTIVE, F::ROUND, F::CURRENTPARTICIPANTID];
        // On met à jour
        $this->writer->updatePartial($initiativeTracker, $changedFields);

        return [
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }
}
