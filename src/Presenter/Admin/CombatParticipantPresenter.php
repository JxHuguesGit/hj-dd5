<?php
namespace src\Presenter\Admin;

use src\Collection\Collection;
use src\Constant\Template as T;
use src\Domain\Entity\CombatParticipant;
use src\Renderer\TemplateRenderer;

final class CombatParticipantPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function present(CombatParticipant $participant): string
    {
        $attributes = [
            'id' => $participant->id,
            'name' => $participant->name,
            'initiative' => $participant->initiative,
            'ac' => $participant->ac,
            'hp' => $participant->hp,
            'maxHp' => $participant->maxHp,
            'classType' => 'npc',
            'stringType' => 'NPC',
            'iconType' => 'user',
        ];

        return $this->renderer->render(
            T::ADMINCOMBATPARTICIPANT,
            $attributes
        );
    }

    public function presentCollection(Collection $participants): string
    {
        $html = '';

        foreach ($participants as $participant) {
            $html .= $this->present($participant);
        }

        return $html;
    }
}
