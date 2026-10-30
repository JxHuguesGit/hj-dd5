<?php

namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITMajCharacter
{
    public function __construct(
        private InitTrackCharacterWriter $writer,
        private InitiativeTrackerReader $itReader,
        private InitiativeTrackerService $itService,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterService $itcService
    ) {}

    public function execute(): array
    {
        $character = Session::fromPost(C::CHARACTER);

        $allowedFields = [
            F::NAME,
            F::SCOREAC,
            F::MAXHP,
            F::MODDEX,
            F::PERCPASSIVE,
            F::INITIATIVE,
            F::REACTIONAVAIL,
            F::READYACTIVE,
            F::SURPRISED,
            F::HEROICINSPAVAIL,
        ];
        $changedFields = [];
        // On instancie
        $itCharacter = $this->itcReader->itCharacterById($character['id']);

        // Si maxHp est défini, curHp ne peut pas être au-dessus
        if (isset($character[F::MAXHP]) && $itCharacter->curHp > $character[F::MAXHP]) {
            $itCharacter->curHp = $character[F::MAXHP];
            $changedFields[] = F::CURHP;
        }

        foreach ($allowedFields as $field) {
            if (isset($character[$field])) {
                $itCharacter->{$field} = $character[$field];
                $changedFields[] = $field;
            }
        }

        // Si ça n'explose pas, on met à jour
        if (!empty($changedFields)) {
            $this->writer->updatePartial($itCharacter, $changedFields);
        }

        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerById($itCharacter->initiativeTrackerId);

        return [
            'asideCard' => $this->itcService->buildAsidePartyMember($itCharacter),
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }
}
