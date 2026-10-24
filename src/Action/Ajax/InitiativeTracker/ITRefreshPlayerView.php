<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Domain\Entity\ITCharacter;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Utils\Session;

final class ITRefreshPlayerView
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
    ) {}

    public function execute(): array
    {
        $sessionId = Session::fromPost('initTrackerId', 0);
        $initiativeTracker = $this->readerFactory->initiativeTracker()->initiativeTrackerByCode($sessionId);
        $iTCharService = $this->serviceFactory->initTrackCharacter();
        $orderedQueue = $iTCharService->getTurnOrder($initiativeTracker);
        $firstCharacter = $orderedQueue->first();

        return [
            'round'       => $initiativeTracker->round,
            'mainHtml'    => $iTCharService->displayCharacter($firstCharacter),
            'footerHtml'  => $iTCharService->displayQueuedCharacters($orderedQueue),
            'combatState' => $this->getCombatState($initiativeTracker->active==1, $firstCharacter)
        ];
    }

    private function getCombatState(bool $active, ITCharacter $initTrackChar): string
    {
        $status = ($active == 1 ? ' combatStarted' : '');
        $status .= ' ' . ($initTrackChar?->characterType ?? '');
        return $status;
    }
}
