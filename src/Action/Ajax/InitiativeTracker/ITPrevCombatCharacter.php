<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Criteria\InitiativeTrackerCriteria;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;

final class ITPrevCombatCharacter
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
        // On récupère le précédent personnage à jouer
        $character = $orderedQueue->last();
        // On récupère l'ordre du tour pour la partie Admin. On commence à chaque fois par la plus haute initiative.
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];
        $adminOrderedQueue = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);

        $changedFields = [];
        if ($character->initiative<$actual->initiative) {
            if ($initiativeTracker->round==1) {
                // On est dans le cas du premier personnage à jouer du combat, on ne peut pas revenir en arrière.
                return [
                    'status' => 'error',
                    'round' => 'Round ' . $initiativeTracker->round,
                    'panel'  => $this->serviceFactory
                        ->initiativeTracker()
                        ->buildIdContentPanel($adminOrderedQueue, $initiativeTracker)
                ];
            } else {
                $initiativeTracker->round--;
                $changedFields[] = F::ROUND;
            }
        }
        $initiativeTracker->currentParticipantId = $character->id;
        $changedFields[] = F::CURRENTPARTICIPANTID;

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
