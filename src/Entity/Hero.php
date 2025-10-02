<?php
namespace src\Entity;

use src\Controller\Hero as ControllerHero;

class Hero extends Entity
{
	private int $ablstr;
	private int $abldex;
	private int $ablcon;
	private int $ablint;
	private int $ablwis;
	private int $ablcha;
    private int $proficiencyBonus;

    public function __construct(
        protected int $id,
        protected string $name,
        protected int $casteId,
        protected int $wpUserId,
        protected int $lastUpdate,
        protected int $createStep = 0
    ) {

    }

    public function getController(): ControllerHero
    {
        $controller = new ControllerHero();
        $controller->setField('entityHero', $this);
        return $controller;
    }

    public function getCasteId(): int
    {
        return $this->casteId;
    }

    public function setCasteId(int $casteId): self
    {
        $this->casteId = $casteId;
        return $this;
    }

    public function getCreateStep(): int
    {
        return $this->createStep;
    }
    
    
    public function getSchemeColor(): string
    {
    	return 'ct-scheme-lightblue';
    }
    
    public function getAbility(string $ability): int
    {
    	return $this->{'abl'.$ability};
    }
    
    public function setAbility(string $ability, int $value): self
    {
    	$this->{'abl'.$ability} = $value;
    	return $this;
    }

	public function getProficiencyBonus(): int
    {
    	return $this->proficiencyBonus;
    }
    
	public function setProficiencyBonus(int $value): self
    {
    	$this->proficiencyBonus = $value;
        return $this;
    }
    
    public function hasProficiencyAbility(string $ability): bool
    {
    	return in_array($ability, ['dex', 'int']);
    }
}