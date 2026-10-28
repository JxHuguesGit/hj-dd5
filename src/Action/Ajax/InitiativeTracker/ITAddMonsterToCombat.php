<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Domain\Entity\ITCharacter;
use src\Service\Domain\InitiativeTrackerService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Reader\MonsterReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITAddMonsterToCombat
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterReader $itcReader,
        private InitTrackCharacterWriter $writer,
        private InitiativeTrackerService $itService,
        private MonsterReader $monsterReader,
    ) {}

    public function execute(): array
    {
        $monsterId = (int) Session::fromPost('monsterId');
        $quantity = (int) Session::fromPost('quantity');
        $itCode = Session::fromPost(F::ITID);

        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);
        $monster = $this->monsterReader->monsterById($monsterId);

        for ($i=1; $i<=$quantity; $i++) {
            $name = $monster->identity()->getFrenchName();
            if (''===$name) {
                $name = $monster->identity()->getName();
            }
            $attributes = [
                F::NAME => $name,
                F::INITIATIVE => random_int(1, 20) + $monster->stats()->getDexterityModifier(),
                F::CHARACTERTYPE => 'monster',
                F::MONSTERID => $monster->identity()->getId(),
                F::SCOREAC => $monster->combat()->getArmorClass(),
                F::MAXHP => $monster->combat()->getHitPoints(),
                F::CURHP => $monster->combat()->getHitPoints(),
                F::MODDEX => $monster->stats()->getDexterityModifier(),
                F::PERCPASSIVE => $monster->stats()->getPassivePerception(),
                F::ITID => $initiativeTracker->id,
                F::ACTIVE => 1,
            ];
            $character = new ITCharacter($attributes);
            $this->writer->insert($character);
        }

        return [
            'panel' => $this->itService->buildActiveCombatPanel($initiativeTracker, $this->itcReader),
        ];
    }

}
