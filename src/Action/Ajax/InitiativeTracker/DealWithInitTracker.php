<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Constant as C;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory;
use src\Utils\Session;

final class DealWithInitTracker
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private WriterFactory $writerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $ajaxAction = Session::fromPost(C::AJAXACTION);

        return match ($ajaxAction) {
            'addInitChar' => (new ITAddCharacter(
                    Session::fromPost(C::CHARACTER),
                    $this->writerFactory->initTrackCharacter()
                ))->execute(),
            'addInitCharToCombat' => (new ITAddCharacterToCombat(
                    Session::fromPost('character_id'),
                    Session::fromPost('initiativeTrackerId'),
                    $this->readerFactory->initTrackCharacter(),
                    $this->readerFactory->initiativeTracker(),
                    $this->writerFactory->initTrackCharacter()
                ))->execute(),
            'delInitChar' => (new ITDelCharacter(
                    $this->writerFactory->initTrackCharacter()
                ))->execute(),
            'updateInitChar' => (new ITMajCharacter(
                    Session::fromPost(C::CHARACTER),
                    $this->writerFactory->initTrackCharacter()
                ))->execute(),
            'setInitChar' => (new ITSetCharCombatInitiative(
                    (int) Session::fromPost('characterId'),
                    (float) Session::fromPost('initiative'),
                    $this->readerFactory,
                    $this->serviceFactory,
                    $this->writerFactory
                ))->execute(),
            'nextCombatChar' => (new ITNextCombatCharacter(
                    Session::fromPost('itCode'),
                    $this->readerFactory,
                    $this->serviceFactory,
                    $this->writerFactory
                ))->execute(),
            'prevCombatChar' => (new ITPrevCombatCharacter(
                    Session::fromPost('itCode'),
                    $this->readerFactory,
                    $this->serviceFactory,
                    $this->writerFactory
                ))->execute(),
            'endCombat' => (new ITEndCombat(
                    Session::fromPost('itCode'),
                    $this->readerFactory,
                    $this->serviceFactory,
                    $this->writerFactory
                ))->execute(),
            'startCombat' => (new ITStartCombat(
                    Session::fromPost('itCode'),
                    $this->readerFactory,
                    $this->serviceFactory,
                    $this->writerFactory
                ))->execute(),
            default => [
                'status' => 'error',
                'message' => 'Action non identifiée.',
            ],
        };
    }

}
