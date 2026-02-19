<?php
namespace src\Domain\CharacterCreation\Step;

use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\CharacterCreation\StepInterface;
use src\Repository\CharacterDraftRepository;

class NameStep implements StepInterface
{
    public function getId(): string
    {
        return 'name';
    }

    public function getTitle(): string
    {
        return 'Nom du personnage';
    }

    public function render(CharacterDraft $draft): string
    {
        $name = htmlspecialchars($draft->name ?? '');

        return "
            <h2>Nom du personnage</h2>
            <form method='post'>
                <label for='name'>Nom :</label>
                <input type='text' id='name' name='name' value='{$name}'>
                <button type='submit'>Continuer</button>
            </form>
        ";
    }

    public function validate(array $input): bool
    {
        if (!isset($input['name'])) {
            return false;
        }

        $name = trim($input['name']);

        return $name !== '' && strlen($name) <= 32;
    }

    public function save(CharacterDraft $draft, array $input, CharacterDraftRepository $repo): void
    {
        $draft->name = trim($input['name']);
        $repo->save($draft);
    }

    public function isComplete(CharacterDraft $draft): bool
    {
        return $draft->name !== null && trim($draft->name) !== '';
    }
}
