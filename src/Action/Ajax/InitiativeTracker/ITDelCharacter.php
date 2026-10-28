<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Service\Domain\InitiativeTrackerService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITDelCharacter
{
    public function __construct(
        private InitTrackCharacterWriter $writer,
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitiativeTrackerService $service
    ) {}

    public function execute(): array
    {
        $id = (int) Session::fromPost('character_id');
        $character = $this->itcReader->itCharacterById($id);
        $initiativeTrackerId = $character->initiativeTrackerId;

        // On supprime
        $this->writer->delete($character);

        $initiativeTracker = $this->itReader->initiativeTrackerById($initiativeTrackerId);

        return [
            'panel' => $this->service->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }


}
