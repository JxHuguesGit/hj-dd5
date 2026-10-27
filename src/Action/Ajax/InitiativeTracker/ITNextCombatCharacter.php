<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;

final class ITNextCombatCharacter
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
        // On récupère l'ordre du tour
        $orderedQueue = $this->serviceFactory->initTrackCharacter()->getTurnOrder($initiativeTracker);
        $actual = $orderedQueue->first();
        // On récupère le prochain personnage à jouer
        $character = $orderedQueue->slice(1, 1)->first();
        // On récupère l'ordre du tour pour la partie Admin. On commence à chaque fois par la plus haute initiative.
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];
        $adminOrderedQueue = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);

        $initiativeTracker->currentParticipantId = $character->id;
        $changedFields = [F::CURRENTPARTICIPANTID];
        // Si on change de round, on doit incrémenter.
        if ($character->initiative>$actual->initiative) {
            $initiativeTracker->round++;
            $changedFields[] = F::ROUND;
        }

        // On met à jour
        $this->writerFactory->initiativeTracker()->updatePartial($initiativeTracker, $changedFields);

        return [
            'status' => 'success',
            'round' => 'Round ' . $initiativeTracker->round,
            'panel'  => $this->serviceFactory
                ->initiativeTracker()
                ->buildIdContentPanel($adminOrderedQueue, $initiativeTracker)
        ];
    }
}
