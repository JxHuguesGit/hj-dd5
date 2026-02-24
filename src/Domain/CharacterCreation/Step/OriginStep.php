<?php
namespace src\Domain\CharacterCreation\Step;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\CharacterCreation\StepInterface;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\OriginRepository;
use src\Service\Reader\OriginReader;
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
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repo = new OriginRepository($queryBuilder, $queryExecutor);
        $reader = new OriginReader($repo);
        $origines = $reader->allOrigins();

        $selId = $draft->originId ?? 0;

        $strOptions = '';
        foreach ($origines as $origine) {
            $strOptions .= $this->getRadioForm($origine->id, $origine->name, $selId==$origine->id);
        }

        return [
            $draft->id,
            $strOptions,
            ''
        ];
    }

    public function getRadioForm(int $id, string $name, bool $checked=false): string
    {
        $strLabel = Html::getBalise('label', $name, [Constant::CST_CLASS=>'form-check-label', 'for'=>'origin'.$id]);
        $attributes = [
            Constant::CST_CLASS => Constant::CST_AJAXACTION,
            Constant::CST_TYPE  => 'radio',
            Constant::CST_NAME  => 'characterOriginId',
            Constant::CST_ID    => 'origin'.$id,
            Constant::CST_VALUE => $id,
            Constant::CST_DATA  => [
                Constant::CST_TRIGGER => 'click',
                Constant::CST_ACTION  => 'loadOrigin'
            ]
        ];
        if ($checked) {
            $attributes['checked'] = 'checked';
        }
        $strInput = Html::getBalise('input', '', $attributes);
        return Html::getDiv($strInput.$strLabel, [Constant::CST_CLASS=>'form-check']);
    }

    public function validate(array $input): bool
    {
        if (!isset($input['characterOriginId'])) {
            return false;
        }

        return true;
    }

    public function save(CharacterDraft $draft, array $input): void
    {
        $draft->originId   = $input['characterOriginId'];
    }

    public function isComplete(CharacterDraft $draft): bool
    {
        return $draft->originId !== null && trim($draft->originId) !== '';
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
