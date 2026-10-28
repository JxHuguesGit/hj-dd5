<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITSetCharCombatInitiative
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitiativeTrackerService $service,
        private InitTrackCharacterWriter $writer,
    ){}

    public function execute(): array
    {
        $itCharacterId = (int) Session::fromPost('characterId');
        $initiative = (float) Session::fromPost(F::INITIATIVE);

        $character = $this->itcReader->itCharacterById($itCharacterId);
        $character->initiative = $initiative;
        $this->writer->updatePartial($character, [F::INITIATIVE]);

        $initiativeTracker = $this->itReader->initiativeTrackerById($character->initiativeTrackerId);
        
        return [
            'panel' => $this->service->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }

}
