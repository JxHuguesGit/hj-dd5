<?php
namespace src\CharacterCreation;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHerosClasse;
use src\Utils\Session;

class ClasseStep extends AbstractStep
{
    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            return; // Rien à valider
        }
        
        // On récupère et nettoie la valeur
        $classeId = (int) trim(Session::fromPost('classeId', ''));
        if ($classeId <= 0) {
            // Pas d’erreur UI ici → juste pas de progression d’étape
            return;
        }

        $classe = $this->deps['classRepo']->find($classeId);
        if (!$classe) {
            return;
        }

        $heroClasses = $this->deps['heroClassRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        foreach ($heroClasses as $heroClasse) {
            $this->deps['heroClassRepo']->delete($heroClasse);
        }
        
        $heroClasse = new RpgHerosClasse([Field::HEROSID=>$this->hero->getField(Field::ID), Field::CLASSEID=>$classeId, Field::NIVEAU=>1]);
        $this->deps['heroClassRepo']->insert($heroClasse);


        $this->hero->setField(Field::CREATESTEP, 'skillTool');
        $this->hero->setField(Field::LASTUPDATE, time());
        $this->deps['heroRepo']->update($this->hero);
    }

    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();

        $heroClasses = $this->deps['heroClassRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        $heroClassesArray = iterator_to_array($heroClasses);
        $heroClasse = $heroClassesArray[0] ?? null;
        $selectedId = $heroClasse?->getClasse()->getField(Field::ID) ?? -1;

        // Préparer les variables pour le template
        $classes = $this->deps['classRepo']->findAll([Field::NAME=>Constant::CST_ASC]);
        $strRadios = '';
        foreach ($classes as $classe) {
            $strRadios .= $classe->getController()->getRadioForm('classeId', $selectedId == $classe->getField(Field::ID));
        }

        return [
            'template'  => Template::CREATE_CLASSE,
            'variables' => [
                'sidebar'       => $sidebar,
                'heroId'        => $this->hero->getField(Field::ID),
                'boutonsRadio'  => $strRadios,
                'description'   => '',
            ],
        ];
    }

    public static function getSidebarLabel(): string
    {
        return 'Classe';
    }

    public function getSidebarValue(): string
    {
        $heroClasses = $this->deps['heroClassRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        $classes = iterator_to_array($heroClasses);
        $heroClasse = $classes[0] ?? null;
        return $heroClasse?->getClasse()->getField(Field::NAME) ?? '';
    }
}
