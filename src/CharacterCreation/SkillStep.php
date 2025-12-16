<?php
namespace src\CharacterCreation;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHerosSkill;
use src\Utils\Session;

class SkillStep extends AbstractStep
{
    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            // Rien à valider
            return;
        }
        
        $herosId = $this->hero->getField(Field::ID);
        
        // On récupère et nettoie la valeur
        // On fait ici le traitement spécifique des données de l'écran
        // Suppression des liens herosSkill
        $heroSkills = $this->deps['heroSkillRepo']->findBy([Field::HEROSID=>$herosId]);
        foreach ($heroSkills as $heroSkill) {
            $this->deps['heroSkillRepo']->delete($heroSkill);
        }
        // Création des liens herosSkill
        $skillIds = Session::fromPost('skillId');
        foreach ($skillIds as $skillId) {
            $heroSkill = new RpgHerosSkill([Field::HEROSID=>$herosId, Field::SKILLID=>$skillId, Field::EXPERTISE=>0]);
            $this->deps['heroSkillRepo']->insert($heroSkill);
        }
        // Suppression des liens herosTool
        // Création des liens herosTool
        ////////

        // Temporairement skill pour rester sur la même page le temps de son développement
        // TODO : à modifier avec le bon paramètre le moment venu.
        $this->hero->setField(Field::CREATESTEP, 'skillTool');
        $this->hero->setField(Field::LASTUPDATE, time());
        $this->deps['heroRepo']->update($this->hero);
    }
    
    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();
        $herosId = $this->hero->getField(Field::ID);
        
        // On doit récupérer les herosSkill
        $heroSkills = $this->deps['heroSkillRepo']->findBy([Field::HEROSID=>$herosId]);
        // On va aussi récupérer les originSkill pour savoir ceux qui ne sont pas modifiables
        $originSkills = $this->deps['originSkillRepo']->findBy([Field::ORIGINID=>$this->hero->getField(Field::ORIGINID)]);
        // On va récupérer les classeSkill pour savoir ceux qui sont accessibles par la classe
        $classeSkills = $this->deps['classSkillRepo']->findBy([Field::CLASSEID=>12]);
        
        // Récupérer les Skill
        $originSkillHtml = '';
        $classeSkillHtml = '';
        $skillHtml = '';
        $skills = $this->deps['skillRepo']->findAll([Field::NAME=>Constant::CST_ASC]);
        foreach ($skills as $skill) {
            $skillIdToFind = $skill->getField(Field::ID);
            $filtered = $heroSkills->filter(function ($item) use ($skillIdToFind) {
                return $item->getField(Field::SKILLID) === $skillIdToFind;
            });
            $filteredOrigin = $originSkills->filter(function ($item) use ($skillIdToFind) {
                return $item->getField(Field::SKILLID) === $skillIdToFind;
            });
            $filteredClasse = $classeSkills->filter(function ($item) use ($skillIdToFind) {
                return $item->getField(Field::SKILLID) === $skillIdToFind;
            });
            
            if ($filteredOrigin->length()>0) {
                $originSkillHtml .= $skill->getController()->getCheckboxForm(true, true);
            } else {
                if ($filteredClasse->length()>0) {
                    $classeSkillHtml .= $skill->getController()->getCheckboxForm($filtered->length()>0);
                }
                $skillHtml .= $skill->getController()->getCheckboxForm($filtered->length()>0);
            }
        }
        // TODO : On doit décider si les skills associés à l'origine peuvent être modifiés.
        // On doit construire l'interface en s'appuyant sur ces deux listes
        
        // On doit récupérer les herosTool
        // Récupérer les Tool
        $originToolId = $this->hero->getOrigin()->getField(Field::TOOLID);
        $originToolHtml = '';
        $toolHtml = '';
        $tools = $this->deps['toolRepo']->findAll([Field::NAME=>Constant::CST_ASC]);
        foreach ($tools as $tool) {
            $filteredOrigin = $tool->getField(Field::ID) == $originToolId;

            if ($filteredOrigin) {
                $originToolHtml .= $tool->getController()->getCheckboxForm(true, true);
            } else {
                $toolHtml .= $tool->getController()->getCheckboxForm(false/*$filtered->length()>0*/);
            }
        }
        // On doit construire l'interface en s'appuyant sur ces deux listes.
        
        // On devrait déterminer aussi à combien de Skill et de Tool le personnage a le droit.
        $heroClasses = $this->deps['heroClassRepo']->findBy([Field::HEROSID=>$this->hero->getField(Field::ID)]);
        $classes = iterator_to_array($heroClasses);
        $heroClasse = $classes[0] ?? null;
        $nbSkillsByClasse = $heroClasse?->getClasse()->getField(Field::SKILLS) ?? 0;
        // On doit déterminer la classe du personnage. Dans rpgHerosClasse.
        
        
        return [
            'template'  => Template::CREATE_SKILLTOOL,
            'variables' => [
                'sidebar'           => $sidebar,
                'heroId'            => $herosId,
                'originSkillHtml'   => $originSkillHtml,
                'toolSkillHtml'     => $originToolHtml,
                'skillByClass'      => $nbSkillsByClasse,
                'classeSkillHtml'   => $classeSkillHtml,
                'skillsHtml'        => $skillHtml,
                'toolsHtml'         => $toolHtml,
                '', '', '', '',
            ],
        ];
    }
    
    public static function getSidebarLabel(): string
    {
        return 'Compétences et outils';
    }

    public function getSidebarValue(): string
    {
        return 'Compétences et outils à faire.';
    }
}
