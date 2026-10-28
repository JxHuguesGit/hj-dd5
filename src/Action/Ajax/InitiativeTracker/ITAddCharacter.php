<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Domain\Entity\ITCharacter;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Writer\InitTrackCharacterWriter;
use src\Utils\Session;

final class ITAddCharacter
{
    public function __construct(
        private InitTrackCharacterWriter $writer,
        private InitTrackCharacterService $service
    ) {}

    public function execute(): array
    {
        $character = Session::fromPost(C::CHARACTER);
        // On met à jour
        $character['initiativeTrackerId'] = 1;
        // On instancie
        $itCharacter = new ITCharacter($character);
        // Si ça n'explose pas, on insère
        $this->writer->insert($itCharacter);

        return [
            'asideCard' => $this->service->buildAsidePartyMember($itCharacter)
        ];
    }


}
