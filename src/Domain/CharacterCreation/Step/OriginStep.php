<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Language;
use src\Constant\Template;
use src\Domain\CharacterCreation\StepInterface;
use src\Domain\Character\Character;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\OriginRepository;
use src\Service\Domain\CharacterServices;
use src\Service\Reader\OriginReader;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class OriginStep extends AbstractBaseStep implements StepInterface
{
    public function __construct()
    {
        $this->id       = Constant::ORIGIN;
        $this->title    = Language::LG_CHAR_HIST_TITLE;
        $this->template = Template::CREATE_ORIGIN;
    }

    public function render(Character $character): array
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repo          = new OriginRepository($queryBuilder, $queryExecutor);
        $reader        = new OriginReader($repo);
        $origines      = $reader->allOrigins();

        $selId = $character->originId ?? 0;

        $strOptions = '';
        foreach ($origines as $origine) {
            $strOptions .= $this->getRadioForm($origine->id, $origine->name, $selId == $origine->id);
        }

        return [
            $character->id,
            $strOptions,
            '',
        ];
    }

    public function getRadioForm(int $id, string $name, bool $checked = false): string
    {
        $strLabel   = Html::getBalise('label', $name, [Constant::CST_CLASS => 'form-check-label', 'for' => 'origin' . $id]);
        $attributes = [
            Constant::CST_CLASS => Constant::CST_AJAXACTION,
            Constant::CST_TYPE  => 'radio',
            Constant::CST_NAME  => 'characterOriginId',
            Constant::CST_ID    => 'origin' . $id,
            Constant::CST_VALUE => $id,
            Constant::CST_DATA  => [
                Constant::CST_TRIGGER => 'click',
                Constant::CST_ACTION  => 'loadOrigin',
            ],
        ];
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        $strInput = Html::getBalise('input', '', $attributes);
        return Html::getDiv($strInput . $strLabel, [Constant::CST_CLASS => 'form-check']);
    }

    public function validate(array $input): bool
    {
        if (! isset($input['characterOriginId'])) {
            return false;
        }

        return true;
    }

    public function save(CharacterServices $services, Character $character, array $input): void
    {
        // Initialisation
        $character->initialize($input);
        // Sauvegarde
        // On doit supprimer les entrées dans rpgCharacterSkill
        // originServices->getSkills()
        // On doit créer les entrées dans rpgCharacterSkill
        // On doit supprimer les entrées dans rpgCharacterTool
        // On doit créer les entrées dans rpgCharacterTool
        // On doit supprimer les entrées dans rpgCharacterFeat
        // On doit créer les entrées dans rpgCharacterFeat

        $services->writer()->save($character);
    }

    public function isComplete(Character $character): bool
    {
        return $character->originId !== null && trim($character->originId) !== '';
    }

    public function sidebar(Character $character): array
    {
        $url = UrlGenerator::admin(Constant::ONG_CHARACTER, $character->id, '', '', ['step' => '%s']);
        return [
            $character->id,
            Html::getLink('Nom', sprintf($url, 'name'), Bootstrap::CSS_TEXT_DARK) . ' : ' . $character->name,
        ];
    }
}
