<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Entity\ITCharacter;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITAddCharacter
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterWriter $writer,
        private InitTrackCharacterService $service
    ) {}

    public function execute(): array
    {
        $character = Session::fromPost(C::CHARACTER);
        $itCode = $character['initiativeTrackerId'];
        // On récupère la table associée
        $initiativeTracker = $this->itReader->initiativeTrackerByCode($itCode);
        $character[F::CURHP] = $character[F::MAXHP];

        // On met à jour
        $character['initiativeTrackerId'] = $initiativeTracker->id;
        // On instancie
        $itCharacter = new ITCharacter($character);
        // Si ça n'explose pas, on insère
        $this->writer->insert($itCharacter);

        return [
            'asideCard' => $this->service->buildAsidePartyMember($itCharacter)
        ];
    }


}
