<?php
namespace src\Action\Ajax;

use src\Domain\Criteria\CombatParticipantCriteria;
use src\Factory\ReaderFactory;
use src\Factory\WriterFactory;

final class RemoveCreatureFromCombatAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
    ) {}

    public function execute(): array
    {
        $participantId = (int) filter_input(
            INPUT_POST,
            'participantId',
            FILTER_VALIDATE_INT
        );

        $criteria = new CombatParticipantCriteria();
        $criteria->id = $participantId;

        $combatParticipants = $this->readerFactory
            ->combatParticipant()
            ->allCombatParticipants($criteria);
        if ($combatParticipants === null) {
            return [
                'status' => 'error',
                'message' => 'Participant inconnu.',
            ];
        }
        $combatParticipant = $combatParticipants->first();
        
        $this->writerFactory
            ->combatParticipant()
            ->delete($combatParticipant);

        return ['status' => 'success'];
    }
}
