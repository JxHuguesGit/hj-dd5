<?php

namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Domain\Criteria\TokenCriteria;
use src\Domain\Entity\Combat;
use src\Domain\Entity\CombatParticipant;
use src\Domain\Entity\Token;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;

final class AddCreatureToCombatAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function controleInput(Monster &$monster, Token &$token): array
    {
        $returnedArray = [];

        $monsterId = (int) filter_input(
            INPUT_POST,
            'monsterId',
            FILTER_VALIDATE_INT
        );
        $monster = $this->readerFactory
            ->monster()
            ->monsterById($monsterId);
        if ($monster === null) {
            $returnedArray = [
                'status' => 'error',
                'message' => 'Monstre inconnu.',
            ];
        } else {
            // Ici, on va récupérer dans token un type='monster' et entityId='monsterId'
            // On peut
            $criteria = new TokenCriteria();
            $criteria->type = "monster";
            $criteria->entityId = $monsterId;
            $tokens = $this->readerFactory
                ->token()
                ->allTokens($criteria);
            if ($tokens->isEmpty()) {
                return [
                    'status' => 'error',
                    'message' => 'Token non défini pour ce monstre.',
                ];
            } else {
                $token = $tokens->first();
            }
        }

        return $returnedArray;
    }
    public function execute(): array
    {
        $monster = new Monster();
        $token = new Token();

        $returnedArray = $this->controleInput($monster, $token);

        if (empty($returnedArray)) {
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
                F::TOKENID => $token->id,
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
        return $returnedArray;
    }
}
