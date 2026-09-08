<?php

namespace src\Action\Ajax;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Entity\CombatParticipant;
use src\Factory\ReaderFactory;
use src\Factory\WriterFactory;
use src\Utils\Session;

final class UpdateCombatParticipantAction
{
    public const UNKNOWN_USER = 'Participant inconnu.';

    public function __construct(
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
    ) {}

    public function execute(): array
    {
        $ajaxAction = Session::fromPost(C::AJAXACTION);

        $return = [];
        // Potentiellement, on a plusieurs branches qui arrivent ici.
        switch ($ajaxAction) {
            // Retirage de l'initiative
            case 'rerollCombatParticipantInitiative' :
                $return = $this->rollInitiative();
            break;
            case 'addHitPoint' :
                // Ajout de points de vie
                $return = $this->addHitPoint();
            break;
            case 'removeHitPoint' :
                // Retrait de points de vie (potentiellement mutualisé avec le précédent)
                $return = $this->removeHitPoint();
            break;
            default :
                // Ajout / Retrait d'états (ou autre puisque ce sera la table jointe qui sera impactée)
            break;
        }
        return $return;
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
            ->participantById($participantId);
        if ($combatParticipant === null) {
            return [
                'status' => 'error',
                'message' => self::UNKNOWN_USER,
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
            ->participantById($participantId);
        if ($combatParticipant === null) {
            return [
                'status' => 'error',
                'message' => self::UNKNOWN_USER,
            ];
        }

        // On a le nombre de pv à ajouter
        $modHp = (int) filter_input(
            INPUT_POST,
            'modHp',
            FILTER_VALIDATE_INT
        );

        $combatParticipant->hp = max(0, $combatParticipant->hp - $modHp);
        $changedFields = [F::SCOREHP];
        $this->writerFactory->updatePartial(
            $combatParticipant,
            $changedFields
        );

        return [];
    }

    private function controleInitiative(
        ?CombatParticipant &$combatParticipant,
        string &$type,
        int &$entityId
    ): array
    {
        $returnedArray = [];

        // On a le participantId
        $participantId = (int) filter_input(
            INPUT_POST,
            'participantId',
            FILTER_VALIDATE_INT
        );
        // On récupère l'objet CombatParticipant associé
        $combatParticipant = $this->readerFactory
            ->combatParticipant()
            ->participantById($participantId);
        if ($combatParticipant === null) {
            $returnedArray = [
                'status' => 'error',
                'message' => self::UNKNOWN_USER,
            ];
        } else {
            // On a donc le tokenId
            $tokenId = $combatParticipant->tokenId;
            // On récupère l'objet Token associé
            $token = $this->readerFactory
                ->token()
                ->tokenById($tokenId);
            if ($token === null) {
                $returnedArray = [
                    'status' => 'error',
                    'message' => 'Token pour le participant &lt;'.$combatParticipant->name.'&gt; non défini.',
                ];
            } else {
                // On a donc le entityId et le type
                $type = $token->type;
                $entityId = $token->entityId;
            }
        }
        return $returnedArray;
    }

    private function rollInitiative(): array
    {
        $combatParticipant = new CombatParticipant();
        $type = '';
        $entityId = 0;
        $returnedArray = $this->controleInitiative($combatParticipant, $type, $entityId);

        if (empty($returnedArray)) {
            // Si type vaut 'monster'
            if ($type=='monster') {
            //    alors on récupère l'objet Monster associé à entityId
                $monster = $this->readerFactory
                    ->monster()
                    ->monsterById($entityId);
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
                $this->writerFactory
                    ->combatParticipant()
                    ->updatePartial(
                        $combatParticipant,
                        $changedFields
                    );
            }
            // Si type vaut 'character'
            //    alors on récupère l'objet Character associé à entityId
            return [];
        }

        return $returnedArray;
    }
}
