<?php

namespace src\Action\Ajax;

use src\Constant\Field as F;
use src\Factory\ReaderFactory;
use src\Factory\WriterFactory;

final class UpdateCombatParticipantAction
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
    ) {}

    public function execute(): array
    {
        $tmp = [];
        // Potentiellement, on a plusieurs branches qui arrivent ici.
        // Retirage de l'initiative
        $tmp = $this->rollInitiative();
        // Ajout de points de vie
        $tmp = $this->addHitPoint();
        // Retrait de points de vie (potentiellement mutualisé avec le précédent)
        $tmp = $this->removeHitPoint();
        // Ajout / Retrait d'états (ou autre puisque ce sera la table jointe qui sera impactée)
        return $tmp;
    }

    private function addHitPoint(): array
    {
        // On a le participantId
        $participantId = (int) filter_input(
            INPUT_POST,
            'participantId',
            FILTER_VALIDATE_INT
        );

        // On récupère l'objet CombatParticipant associé
        $combatParticipant = $this->readerFactory
            ->combatParticipant()
            ->findById($participantId);
        if ($combatParticipant === null) {
            return [
                'status' => 'error',
                'message' => 'Participant inconnu.',
            ];
        }

        // On a le nombre de pv à ajouter
        $modHp = (int) filter_input(
            INPUT_POST,
            'modHp',
            FILTER_VALIDATE_INT
        );

        $combatParticipant->hp = min($combatParticipant->maxHp, $combatParticipant->hp + $modHp);
        $changedFields = [F::SCOREHP];
        $this->writerFactory->updatePartial(
            $combatParticipant,
            $changedFields
        );

        return [];
    }

    private function removeHitPoint(): array
    {
        // On a le participantId
        $participantId = (int) filter_input(
            INPUT_POST,
            'participantId',
            FILTER_VALIDATE_INT
        );

        // On récupère l'objet CombatParticipant associé
        $combatParticipant = $this->readerFactory
            ->combatParticipant()
            ->findById($participantId);
        if ($combatParticipant === null) {
            return [
                'status' => 'error',
                'message' => 'Participant inconnu.',
            ];
        }

        // On a le nombre de pv à ajouter
        $modHp = (int) filter_input(
            INPUT_POST,
            'modHp',
            FILTER_VALIDATE_INT
        );

        // TODO : faudrait gérer le cas à 0 points de vie.
        // Si c'est un PJ, il ne meurt pas. Si c'est un monstre, il meurt.
        $combatParticipant->hp = max(0, $combatParticipant->hp - $modHp);
        $changedFields = [F::SCOREHP];
        $this->writerFactory->updatePartial(
            $combatParticipant,
            $changedFields
        );

        return [];
    }

    private function rollInitiative(): array
    {
        // On a le participantId
        $participantId = (int) filter_input(
            INPUT_POST,
            'participantId',
            FILTER_VALIDATE_INT
        );

        // On récupère l'objet CombatParticipant associé
        $combatParticipant = $this->readerFactory
            ->combatParticipant()
            ->findById($participantId);
        if ($combatParticipant === null) {
            return [
                'status' => 'error',
                'message' => 'Participant inconnu.',
            ];
        }
        // On a donc le tokenId
        $tokenId = $combatParticipant->tokenId;
        // On récupère l'objet Token associé
        $token = $this->readerFactory
            ->token()
            ->findById($tokenId);
        if ($token === null) {
            return [
                'status' => 'error',
                'message' => 'Token pour le participant &lt;'.$combatParticipant->name.'&gt; non défini.',
            ];
        }
        // On a donc le entityId et le type
        $type = $token->type;
        $entityId = $token->entityId;

        // Si type vaut 'monster'
        if ($type=='monster') {
        //    alors on récupère l'objet Monster associé à entityId
            $monster = $this->readerFactory
                ->monster()
                ->findById($entityId);
            if ($monster === null) {
                return [
                    'status' => 'error',
                    'message' => 'Monstre inconnu.',
                ];
            }
        //          on récupère initiative
            $modInitiative = $monster->initiative;
        //          on roll 1d20 + initiative
            $initiative = random_int(1, 20) + $modInitiative;
        //          on met à jour CompatParticipant->initiative
            $combatParticipant->initiative = $initiative;
            $changedFields = [F::INITIATIVE];
            $this->writerFactory->updatePartial(
                $combatParticipant,
                $changedFields
            );
        }
        // Si type vaut 'character'
        //    alors on récupère l'objet Character associé à entityId


        return [];
    }
}
