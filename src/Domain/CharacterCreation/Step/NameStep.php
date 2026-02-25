<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Constant;
use src\Constant\Language;
use src\Constant\Template;
use src\Domain\CharacterCreation\StepInterface;
use src\Domain\Character\Character;
use src\Service\Domain\CharacterServices;

final class NameStep extends AbstractBaseStep implements StepInterface
{
    public function __construct()
    {
        $this->id       = Constant::CST_NAME;
        $this->title    = Language::LG_CHAR_NAME_TITLE;
        $this->template = Template::CREATE_NAME;
    }

    public function render(Character $character): array
    {
        return [
            $character->id ?? 0,
            htmlspecialchars($character->name ?? ''),
            '',
        ];
    }

    public function validate(array $input): bool
    {
        if (! isset($input['characterName'])) {
            return false;
        }

        $name = trim($input['characterName']);

        return $name !== '' && strlen($name) <= 32;
    }

    public function save(CharacterServices $services, Character $character, array $input): void
    {
        // Initialisation
        $input['characterOriginId'] = null;
        $character->initialize($input);
        // Sauvegarde
        $services->writer()->save($character);
    }

    public function isComplete(Character $character): bool
    {
        return $character->name !== null && trim($character->name) !== '';
    }

    public function sidebar(Character $character): array
    {
        return [
            $character->id,
            '',
        ];
    }
}
