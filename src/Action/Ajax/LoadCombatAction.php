<?php
namespace src\Action\Ajax;

use src\Factory\PresenterFactory;
use src\Factory\ReaderFactory;

final class LoadCombatAction implements AjaxActionInterface
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private PresenterFactory $presenterFactory,
    ) {}

    public function execute(): array
    {
        $combat = null;
        $participants = [];

        $combatId = filter_input(INPUT_POST, 'combatId', FILTER_VALIDATE_INT);
        if ($combatId !== false && $combatId !== null) {
            $combat = $this->readerFactory
                ->combat()
                ->combatById($combatId);

            if ($combat !== null) {
                $participants = $this->readerFactory
                    ->combatParticipant()
                    ->participantsByCombat($combatId);
            }
        }

        return [
            'header' => $this->presenterFactory->combat()->presentHeader($combat),
            'participants' => $this->presenterFactory->combatParticipant()->presentCollection($participants),
        ];
    }
}
