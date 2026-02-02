<?php
namespace src\Presenter\ViewModel;

use src\Domain\Skill as DomainSkill;

class SkillPageView
{
    public function __construct(
        public DomainSkill $skill,
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
