<?php

namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Domain\Entity\ITCharacter;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITDealWithHp
{
    private int $amount;

    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitiativeTrackerService $service,
        private InitTrackCharacterWriter $writer,
        private string $type,
    ) {}

    public function execute(): array
    {
        $characterId = (int) Session::fromPost('combatantId');
        $this->amount = (int) Session::fromPost('amount');

        // On récupère le combattant concerné
        $character = $this->itcReader->itCharacterById($characterId);
        $changedFields = [];
        switch ($this->type) {
            case 'dealDamage':
                $this->dealDamage($character, $changedFields);
                break;
            case 'heal':
                $this->heal($character, $changedFields);
                break;
            case 'setTempHP':
                $this->setTempHp($character, $changedFields);
                break;
            default:
                throw new \InvalidArgumentException(
                    'Type d’action invalide pour ITDealWithHp : ' . $this->type
                );
        }
        // On met à jour
        if (!empty($changedFields)) {
            $this->writer->updatePartial($character, $changedFields);
        }

        $initiativeTracker = $this->itReader->initiativeTrackerById($character->initiativeTrackerId);
        $isActive = $initiativeTracker->currentParticipantId == $character->id;

        return [
            'panel'  => $this->service->buildCombatMember($character, $isActive),
        ];
    }

    private function setTempHp(ITCharacter $character, array &$changedFields): void
    {
        if ($this->amount > $character->tmpHp) {
            $character->tmpHp = $this->amount;
            $changedFields = [F::TMPHP];
        }
    }

    private function heal(ITCharacter $character, array &$changedFields): void
    {
        $character->curHp = min($character->maxHp, $character->curHp + $this->amount);
        $changedFields = [F::CURHP];
    }

    private function dealDamage(ITCharacter $character, array &$changedFields): void
    {
        if ($character->tmpHp == 0) {
            $character->curHp = max(0, $character->curHp - $this->amount);
            $changedFields = [F::CURHP];
        } elseif ($character->tmpHp >= $this->amount) {
            $character->tmpHp -= $this->amount;
            $changedFields = [F::TMPHP];
        } else {
            $character->curHp = max(0, $character->curHp - $this->amount + $character->tmpHp);
            $character->tmpHp = 0;
            $changedFields = [F::CURHP, F::TMPHP];
        }
    }
}
