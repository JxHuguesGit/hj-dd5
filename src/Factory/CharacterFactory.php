<?php
namespace src\Factory;

use src\Domain\CharacterCreation\CharacterCreationFlow;
use src\Domain\Character\Character;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\CharacterServices;

final class CharacterFactory
{
    public function __construct(
        private CharacterServices $services,
        private TemplateRenderer $renderer
    ) {}

    public function load(int $id): CharacterCreationFlow
    {
        $character = $this->services->reader()->characterById($id);
        if (! $character) {
            $character = $this->newCharacter();
        }
        return new CharacterCreationFlow($character, $this->services, $this->renderer);
    }

    public function init(): CharacterCreationFlow
    {
        $character = $this->newCharacter();
        return new CharacterCreationFlow($character, $this->services, $this->renderer);
    }

    private function newCharacter(): Character
    {
        $character = new Character();
        $character->initialize();
        return $character;
    }

}
