<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Domain\Entity\ITCharacter;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;

final class InitiativeTrackerService
{
    public function __construct(
        private InitTrackCharacterReader $itCharacterReader,
        private InitTrackCharacterWriter $writerITChar,
        private TemplateRenderer $renderer,
    ) {}

    public function buildIdContentPanel(Collection $members, InitiativeTracker $initiativeTracker): string
    {
        $content = '';
        foreach ($members as $member) {
            if ($member->active==0) {
                continue;
            }
            $content .= $this->buildCombatMember($member, $initiativeTracker->currentParticipantId==$member->id);
        }
        return $content;
    }

    private function buildCombatMember(ITCharacter $member, bool $active): string
    {
        $classMember  = $member->characterType == 'player' ? 'character' : $member->characterType;
        $classMember .= $active ? ' active' : '';
        
        return $this->renderer->render(
            T::ADMIN_IT_CONTENT_PANEL,
            [
                $member->id,
                $classMember,
                $member->name,
                $member->maxHp,
                $member->ac,
                $member->initiative == null ? '-' : floor($member->initiative),
                $member->initiative == null ? '' : floor($member->initiative),
                $member->curHp,
            ]
        );
    }




}
