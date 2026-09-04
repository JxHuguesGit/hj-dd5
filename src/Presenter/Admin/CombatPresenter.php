<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Domain\Entity\Combat;
use src\Factory\ReaderFactory;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;


final class CombatPresenter
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private TemplateRenderer $renderer
    ) {}

    public function presentHeader(Combat $combat): string
    {
        if ($combat === null || !$combat->active) {
            return Html::getButton(
                Html::getIcon(I::SWORDS) . ' Débuter le combat',
                [
                    C::CSSCLASS => 'btn btn--combat-start btn--full',
                ]
            );
        } else {
            // On récupère $combat->currentParticipantId
            // On récupère CombatParticipant, d'après $combat->currentParticipantId
            $combatParticipant = $this->readerFactory
                ->combatParticipant()
                ->findById($combat->currentParticipantId);
            if ($combatParticipant === null) {
                return 'Participant inconnu.';
            }

            // Comment on récupère previous ?
            // On cherche un CombatParticipant avec même combatId et initiative > à celle de notre CombatParticipant.
            // S'il n'y a rien, on bloque previous (ça reviendrait à revenir au round précédent)

            // Comment on récupère next ?
            // On cherche un CombatParticipant avec même combatId et initiative < à celle de notre CombatParticipant.
            // S'il n'y a rien, on bloque next (ça reviendrait à avancer au round suivant)

            $attributes = [
                '', // prev disabled ? ' disabled=""' : ''
                $combat->round,
                $combatParticipant->name,
                '', // next disabled ? ' disabled=""' : ''
            ];

            return $this->renderer->render(
                T::ADMININITCBTBUTTON,
                $attributes
            );
        }
    }
}
