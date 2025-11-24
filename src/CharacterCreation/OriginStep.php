<?php
namespace src\CharacterCreation;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHerosSkill;
use src\Entity\RpgOrigin;
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

        // On va récupérer les compétences associées au personnage pour les supprimer.
        $heroSkills = $this->deps['heroSkillRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        foreach ($heroSkills as $heroSkill) {
            $this->deps['heroSkillRepo']->delete($heroSkill);
        }

        // On va récupérer les deux compétences associées à cette origine pour les attacher au personnage.
        $originSkills = $this->deps['originSkillRepo']->findBy([Field::ORIGINID=>$originId]);
        foreach ($originSkills as $originSkill) {
            $heroSkill = new RpgHerosSkill([
                Field::HEROSID=>$this->hero->getField(Field::ID),
                Field::SKILLID=>$originSkill->getField(Field::SKILLID),
                Field::EXPERTISE=>0
            ]);
            $this->deps['heroSkillRepo']->insert($heroSkill);
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
        $refOrigin = null;
        $strRadios = '';
        foreach ($origins as $origin) {
            $matchSelection = $selectedId == $origin->getField(Field::ID);
            $strRadios .= $origin->getController()->getRadioForm($matchSelection);
            if ($matchSelection) {
                $refOrigin = $origin;
            }
        }

        return [
            'template'  => Template::CREATE_ORIGIN,
            'variables' => [
                'sidebar'       => $sidebar,
                'heroId'        => $this->hero->getField(Field::ID),
                'boutonsRadio'  => $strRadios,
                'description'   => $this->getDescription($refOrigin),
            ],
        ];
    }
    
    private function getDescription(?RpgOrigin $origin): string
    {
        if ($origin===null) {
            $returned = "<strong>Caractéristiques</strong> : les 3 caractéristiques ajustées par l'origine.<br>";
            $returned .= "<strong>Don</strong> : le don d'origine associé.<br>";
            $returned .= "<strong>Compétences</strong> : le 2 compétences associées.<br>";
            $returned .= "<strong>Outils</strong> : l'outil associé.<br>";
            $returned .= "<strong>Equipement</strong> : la liste d'équipement standard disponible par l'origine<br>";

            return $returned;
        }
        
        return $origin->getController()->getDescription();
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
