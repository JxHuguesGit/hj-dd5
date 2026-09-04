<?php

namespace src\Service\Domain;

use src\Domain\Entity\Combat;
use src\Domain\Entity\CombatParticipant;
use src\Service\Writer\CombatWriter;
use src\Service\Writer\CombatParticipantWriter;

final class CombatService
{
    public function __construct(
        private CombatWriter $combatWriter,
        private CombatParticipantWriter $combatParticipantWriter,
    ) {}

    public function createCombat(Combat $combat): void
    {
        $this->combatWriter->insert($combat);
    }

    public function deleteCombat(Combat $combat): void
    {
        $this->combatWriter->delete($combat);
    }

    public function addParticipant(
        CombatParticipant $participant
    ): void {
        $this->combatParticipantWriter->insert($participant);
    }

    public function removeParticipant(
        CombatParticipant $participant
    ): void {
        $this->combatParticipantWriter->delete($participant);
    }
}
