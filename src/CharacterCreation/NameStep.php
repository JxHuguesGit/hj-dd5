<?php
namespace src\CharacterCreation;

use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHeros;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Utils\Session;

class NameStep extends AbstractStep
{
    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            // Rien à valider
            return;
        }
        
        // On récupère et nettoie la valeur
        $name = trim(Session::fromPost('characterName', ''));
        if ($name === '') {
            // Pas d’erreur UI ici → juste pas de progression d’étape
            return;
        }

        $this->hero->setField(Field::NAME, $name);
        $this->hero->setField(Field::CREATESTEP, 'origin');
        $this->hero->setField(Field::LASTUPDATE, time());
        
        // Suivant que l’ID existe ou non, insert ou update
        if ($this->hero->getField(Field::ID) == 0) {
            $this->deps['heroRepo']->insert($this->hero);
        } else {
            $this->deps['heroRepo']->update($this->hero);
        }
    }

    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();

        return [
            'template'  => Template::CREATE_NAME,
            'variables' => [
                'sidebar'       => $sidebar,
                'heroId'        => $this->hero->getField(Field::ID),
                'characterName' => $this->hero->getField(Field::NAME),
                // placeholder tant que non implémenté
                'notes'         => '',
            ],
        ];
    }

    public static function getSidebarLabel(): string
    {
        return 'Nom';
    }

    public function getSidebarValue(): string
    {
        return $this->hero->getField(Field::NAME);
    }
}
