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
                $this->readerFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter(),
                $this->serviceFactory->initTrackCharacter()
            ))->execute(),
            'addInitCharToCombat' => (new ITAddCharacterToCombat(
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->writerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker(),
                $this->serviceFactory->initTrackCharacter()
            ))->execute(),
            'rmvInitCharToCombat' => (new ITRmvCharacterToCombat(
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->writerFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker(),
                $this->serviceFactory->initTrackCharacter()
            ))->execute(),
            'addMonsterToCombat' => (new ITAddMonsterToCombat(
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->writerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker(),
                $this->readerFactory->monster()
            ))->execute(),
            'delInitChar' => (new ITDelCharacter(
                $this->writerFactory->initTrackCharacter(),
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker()
            ))->execute(),
            'updateInitChar',
            'toggleReaction',
            'toggleReady',
            'toggleSurprise',
            'toggleInspiration' => (new ITMajCharacter(
                $this->writerFactory->initTrackCharacter(),
                $this->readerFactory->initiativeTracker(),
                $this->serviceFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initTrackCharacter()
            ))->execute(),
            'setInitChar' => (new ITSetCharCombatInitiative(
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter()
            ))->execute(),
            'nextCombatChar' => (new ITNextCombatCharacter(
                $this->readerFactory->initiativeTracker(),
                $this->serviceFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initTrackCharacter(),
                $this->writerFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter()
            ))->execute(),
            'prevCombatChar' => (new ITPrevCombatCharacter(
                $this->readerFactory->initiativeTracker(),
                $this->serviceFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initTrackCharacter(),
                $this->writerFactory->initiativeTracker()
            ))->execute(),
            'endCombat', 'startCombat' => (new ITStartEndCombat(
                $this->readerFactory->initiativeTracker(),
                $this->serviceFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->writerFactory->initiativeTracker(),
                $ajaxAction
            ))->execute(),
            'dealDamage', 'heal', 'setTempHP' => (new ITDealWithHp(
                $this->readerFactory->initiativeTracker(),
                $this->readerFactory->initTrackCharacter(),
                $this->serviceFactory->initiativeTracker(),
                $this->writerFactory->initTrackCharacter(),
                $ajaxAction
            ))->execute(),
            default => throw new \InvalidArgumentException(
                'Action non identifiée.'
            ),
        };
    }
}
