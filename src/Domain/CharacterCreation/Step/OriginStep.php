<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Language as L;
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
        $this->title    = L::CHAR_HIST_TITLE;
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
        $strLabel   = Html::getBalise('label', $name, [Constant::CSSCLASS => 'form-check-label', 'for' => 'origin' . $id]);
        $attributes = [
            Constant::CSSCLASS => Constant::AJAXACTION,
            Constant::TYPE  => 'radio',
            Constant::NAME  => 'characterOriginId',
            Constant::ID    => 'origin' . $id,
            Constant::VALUE => $id,
            Constant::DATA  => [
                Constant::TRIGGER => 'click',
                Constant::ACTION  => 'loadOrigin',
            ],
        ];
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        $strInput = Html::getBalise('input', '', $attributes);
        return Html::getDiv($strInput . $strLabel, [Constant::CSSCLASS => 'form-check']);
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
            Html::getLink('Nom', sprintf($url, 'name'), B::TEXT_DARK) . ' : ' . $character->name,
        ];
    }
}
