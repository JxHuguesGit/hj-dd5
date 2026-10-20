<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Constant\Field as F;
use src\Domain\Entity;
use src\Domain\Entity\ITCharacter;
use src\Renderer\TemplateRenderer;
use src\Service\Writer\InitTrackCharacterWriter;

final class ITMajCharacter extends Entity
{
    public function __construct(
        private array $character,
        private InitTrackCharacterWriter $writer,
    ) {}

    public function execute(): array
    {
        // On instancie
        $itCharacter = new ITCharacter($this->character);
        $changedFields = [F::NAME, F::SCOREAC, F::MAXHP, F::MODDEX, F::PERCPASSIVE];
        // Si ça n'explose pas, on met à jour
        $this->writer->updatePartial($itCharacter, $changedFields);
        // On formate et on renvoie pour affichage.

        return [
            'status'    => 'success',
            'asideCard' => $itCharacter->buildAside(new TemplateRenderer())
        ];
    }


}
