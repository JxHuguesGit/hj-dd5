<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;

final class ITEndCombat
{
    public function __construct(
        private string $itCode,
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private WriterFactory $writerFactory,
    ) {}

    public function execute(): array
    {
        // On récupère la table associée
        $initiativeTracker = $this->readerFactory->initiativeTracker()->initiativeTrackerByCode($this->itCode);

        $initiativeTracker->active = 0;
        $initiativeTracker->round  = 0;
        $initiativeTracker->currentParticipantId = 0;
        $changedFields = [F::ACTIVE, F::ROUND, F::CURRENTPARTICIPANTID];

        // On met à jour
        $this->writerFactory->initiativeTracker()->updatePartial($initiativeTracker, $changedFields);

        // On récupère l'ordre du tour pour la partie Admin. On commence à chaque fois par la plus haute initiative.
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];
        $adminOrderedQueue = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);

        return [
            'status' => 'success',
            'panel'  => $this->serviceFactory
                ->initiativeTracker()
                ->buildIdContentPanel($adminOrderedQueue, $initiativeTracker)
        ];
    }
}
