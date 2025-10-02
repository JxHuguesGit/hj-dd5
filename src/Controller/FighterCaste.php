<?php
namespace src\Controller;

use src\Constant\Template;
use src\Entity\Hero;

class FighterCaste extends Caste
{
    private Hero $hero;

    public function displayDetail(): string
    {
        return $this->getRender(Template::CASTE_DETAIL_FIG);
        /*
        $attributes = [
            'FIG',
            'Fighter',
            'Strength or Dexterity', // Primary Ability
            'D10', // Hit Point Die
            'Strength and Constitution', // Saving Throw Proficiencies
            'Acrobatics, Animal Handling, Athletics, History, Insight, Intimidation, Persuasion, Perception, or Survival', // Skill Proficiencies
            'Simple and Martial weapons', // Weapo Proficiencies
            'Light, Medium, and Heavy armor and Shields', // Armor Training
            '<em>Choose A, B, or C:</em> (A) Chain Mail, Greatsword, Flail, 8 Javelins, Dungeoneer’s Pack, and 4 GP; (B) Studded Leather Armor, Scimitar, Shortsword, Longbow, 20 Arrows, Quiver, Dungeoneer’s Pack, and 11 GP; or (C) 155 GP', // Starting Equipment
        ];
        return $this->getRender(Template::CASTE_DETAIL_GEN, $attributes);
        */
    }

    public function getContentPage(): string
    {
        $stepId = $this->hero->getCreateStep();

        


        return '';
    }

    public function setHero(Hero $hero): self
    {
        $this->hero = $hero;
        return $this;
    }
}
