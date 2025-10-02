<?php
namespace src\Entity;

use src\Controller\Hero as ControllerHero;

class MockHero
{
	private Hero $hero;
    
    public function __construct()
    {
		//$this->_initSheila();
        $this->_initDhommot();
    }
    
    public function getHero(): Hero
    {
    	return $this->hero;
    }

	private function _initDhommot(): void
    {
    	$this->hero = new Hero(
        	2,
            'Dhommot Bronzebeard',
            1,
            5,
            time(),
            -1
        );
        $this->hero->setAbility('str', 16)
            ->setAbility('dex', 8)
            ->setAbility('con', 16)
            ->setAbility('int', 12)
            ->setAbility('wis', 16)
            ->setAbility('cha', 10)
            ->setProficiencyBonus(3);
    }
    
	private function _initSheila(): void
    {
    	$this->hero = new Hero(
        	1,
            'Sheila',
            3,
            1,
            time(),
            -1
        );
        
        $this->hero->setAbility('str', 8)
            ->setAbility('dex', 15)
            ->setAbility('con', 12)
            ->setAbility('int', 14)
            ->setAbility('wis', 14)
            ->setAbility('cha', 12)
            ->setProficiencyBonus(2);
    }
}