<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\CharacterCreation\StepInterface;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class OriginStep implements StepInterface
{
    public string $template = Template::CREATE_ORIGIN;

    public function getId(): string
    {
        return 'origin';
    }

    public function getTitle(): string
    {
        return 'Historique du personnage';
    }

    public function render(CharacterDraft $draft): array
    {
        return ['', '', '', '', '', '', ''];
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
        $draft->name = trim($input['characterName']);
    }

    public function isComplete(CharacterDraft $draft): bool
    {
        return $draft->name !== null && trim($draft->name) !== '';
    }

    public function sidebar(CharacterDraft $draft): array
    {
        $url = UrlGenerator::admin(Constant::ONG_CHARACTER, $draft->id, '', '', ['step'=>'%s']);
        return [
            $draft->id,
            Html::getLink('Nom', sprintf($url, 'name'), Bootstrap::CSS_TEXT_DARK) . ' : ' . $draft->name
        ];
    }
}
