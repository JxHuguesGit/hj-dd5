<?php
namespace src\CharacterCreation;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Utils\Session;

class OriginStep extends AbstractStep
{
    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            return; // Rien à valider
        }
        
        // On récupère et nettoie la valeur
        $originId = (int) trim(Session::fromPost('characterOriginId', ''));
        if ($originId <= 0) {
            // Pas d’erreur UI ici → juste pas de progression d’étape
            return;
        }

        $origin = $this->deps['originRepo']->find($originId);
        if (!$origin) {
            return;
        }

        $this->hero->setField(Field::ORIGINID, $originId);
        $this->hero->setField(Field::CREATESTEP, 'species');
        $this->hero->setField(Field::LASTUPDATE, time());
        $this->deps['heroRepo']->update($this->hero);
    }

    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();

        // Préparer les variables pour le template
        $selectedId = $this->hero->getField(Field::ORIGINID);
        $origins = $this->deps['originRepo']->findAll([Field::NAME=>Constant::CST_ASC]);
        $strRadios = '';
        foreach ($origins as $origin) {
            $strRadios .= $origin->getController()->getRadioForm($selectedId == $origin->getField(Field::ID));
        }

        return [
            'template'  => Template::CREATE_ORIGIN,
            'variables' => [
                'sidebar'       => $sidebar,
                'heroId'        => $this->hero->getField(Field::ID),
                'boutonsRadio'  => $strRadios,
            ],
        ];
    }

    public static function getSidebarLabel(): string
    {
        return 'Origine';
    }

    public function getSidebarValue(): string
    {
        return $this->hero->getOrigin()?->getField(Field::NAME) ?? '';
    }
}