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
    }

    public function getContentPage(): string
    {
        return '';
    }

    public function setHero(Hero $hero): self
    {
        $this->hero = $hero;
        return $this;
    }
}
