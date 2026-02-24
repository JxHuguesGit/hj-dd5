<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Template;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\CharacterCreation\StepInterface;
use src\Utils\Session;

class NameStep implements StepInterface
{
    public string $template = Template::CREATE_NAME;

    public function getId(): string
    {
        return 'name';
    }

    public function getTitle(): string
    {
        return 'Nom du personnage';
    }

    public function render(CharacterDraft $draft): array
    {
        return [
            $draft->id ?? 0,
            htmlspecialchars($draft->name ?? ''),
            ''
        ];
    }

    public function validate(array $input): bool
    {
        if (!isset($input['characterName'])) {
            return false;
        }

        $name = trim($input['characterName']);

        return $name !== '' && strlen($name) <= 32;
    }

    public function save(CharacterDraft $draft, array $input): void
    {
        $draft->id   = trim($input['characterId']);
        $draft->wpUserId = Session::getWpUser()->data->ID;
        $draft->name = trim($input['characterName']);
        $draft->originId = null;
        $draft->speciesId = null;
        $draft->donnees = json_encode([]);
    }

    public function isComplete(CharacterDraft $draft): bool
    {
        return $draft->name !== null && trim($draft->name) !== '';
    }

    public function sidebar(CharacterDraft $draft): array
    {
        return [
            $draft->id,
            ''
        ];
    }
}
