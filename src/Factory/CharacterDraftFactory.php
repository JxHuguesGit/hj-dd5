<?php
namespace src\Factory;

use src\Domain\CharacterCreation\CharacterCreationFlow;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\CharacterDraftReader;
use src\Service\Writer\CharacterDraftWriter;

final class CharacterDraftFactory
{
    public function __construct(
        private CharacterDraftReader $reader,
        private CharacterDraftWriter $writer,
        private TemplateRenderer $renderer
    ) {}

    public function load(int $id): CharacterCreationFlow
    {
        $draft = $this->reader->characterDraftById($id); // à implémenter
        if (!$draft) {
            // fallback : si introuvable, on init un nouveau
            $draft = $this->newDraft();
            //$this->writer->insert($draft);
        }
        return new CharacterCreationFlow($draft, $this->writer, $this->renderer);
    }

    public function init(): CharacterCreationFlow
    {
        $draft = $this->newDraft();
        //$this->writer->insert($draft);

        return new CharacterCreationFlow($draft, $this->writer, $this->renderer);
    }

    private function newDraft(): CharacterDraft
    {
        $draft = new CharacterDraft();
        $draft->createStep = 'name'; // firstStep logique
        $draft->touch();
        return $draft;
    }


}
