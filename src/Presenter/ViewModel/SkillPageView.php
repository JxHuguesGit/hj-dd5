<?php
namespace src\Presenter\ViewModel;

use src\Collection\Collection;
use src\Domain\Ability;
use src\Domain\Skill as DomainSkill;

class SkillPageView
{
    public function __construct(
        public DomainSkill $skill,
        public Collection $subSkills,
        public Ability $ability,
        public Collection $origins,
        public ?DomainSkill $previous = null,
        public ?DomainSkill $next = null,
    ) {}

    public function __get(string $name): mixed
    {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
}
