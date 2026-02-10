<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Entity\Ability;
use src\Domain\Entity\Skill;

class SkillPageView
{
    public function __construct(
        public Skill $skill,
        public Collection $subSkills,
        public Ability $ability,
        public Collection $origins,
        public ?Skill $previous = null,
        public ?Skill $next = null,
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
