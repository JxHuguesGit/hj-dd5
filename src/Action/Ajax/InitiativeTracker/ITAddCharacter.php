<?php
namespace src\Action\Ajax\InitiativeTracker;

use src\Domain\Entity;
use src\Domain\Entity\ITCharacter;
use src\Renderer\TemplateRenderer;
use src\Service\Writer\InitTrackCharacterWriter;

final class ITAddCharacter extends Entity
{
    public function __construct(
        private array $character,
        private InitTrackCharacterWriter $writer,
    ) {}

    public function execute(): array
    {
        $itCode = $this->character['initiativeTrackerId'];
        // On récupère la table associée
        // On met à jour
        $this->character['initiativeTrackerId'] = 1;
        // On instancie
        $itCharacter = new ITCharacter($this->character);
        // Si ça n'explose pas, on insère
        $this->writer->insert($itCharacter);
        // On formate et on renvoie pour affichage.

        return [
            'status' => 'success',
            'panel'  => $itCharacter->buildAside(new TemplateRenderer())
        ];
    }


}
