<?php
namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Entity\Combat;
use src\Domain\Entity\CombatParticipant;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Service\CombatService;

final class AddCreatureToCombatAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $monsterId = (int) filter_input(
            INPUT_POST,
            'monsterId',
            FILTER_VALIDATE_INT
        );
        $monster = $this->readerFactory
            ->monster()
            ->monsterById($monsterId);
        if ($monster === null) {
            return [
                'status' => 'error',
                'message' => 'Monstre inconnu.',
            ];
        }
        
        $combatService = $this->serviceFactory->combat();
        $combatId = (int) filter_input(
            INPUT_POST,
            'combatId',
            FILTER_VALIDATE_INT
        );
        if ($combatId) {
            $combat = $this->readerFactory
                ->combat()
                ->combatById($combatId);

            if ($combat === null) {
                return [
                    'status' => 'error',
                    'message' => 'Combat inconnu.',
                ];
            }
        } else {
            $combat = new Combat();
            $combatService->createCombat($combat);
            $combatId = $combat->id;
        }

        $participant = new CombatParticipant([
            F::COMBATID => $combatId,
            F::TOKENID => null,
            F::MAPTOKENID => null,
            F::NAME => $monster->name,
            F::SCOREHP => $monster->hp,
            F::MAXHP => $monster->hp,
            F::SCOREAC => $monster->ca,
            F::INITIATIVE => random_int(1, 20) + $monster->initiative,
        ]);
        $combatService->addParticipant($participant);

        return ['combatId' => $combatId];
    }
}
