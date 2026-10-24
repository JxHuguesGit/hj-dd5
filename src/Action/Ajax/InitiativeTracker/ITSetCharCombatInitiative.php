<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;

final class ITSetCharCombatInitiative
{
    public function __construct(
        private int $itCharacterId,
        private int $initiative,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private WriterFactory $writerFactory,
    ){}

    public function execute(): array
    {
        $character = $this->readerFactory->initTrackCharacter()->itCharacterById($this->itCharacterId);
        $character->initiative = $this->initiative;
        $this->writerFactory->initTrackCharacter()->updatePartial($character, [F::INITIATIVE]);

        $initiativeTracker = $this->readerFactory->initiativeTracker()->initiativeTrackerById($character->initiativeTrackerId);
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];
        $allCombattants = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);

        
        return [
            'status' => 'success',
            'panel'  => $this->serviceFactory
                ->initiativeTracker()
                ->buildIdContentPanel($allCombattants, $initiativeTracker)
        ];
    }

}
