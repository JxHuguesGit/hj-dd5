<?php
namespace src\Presenter\ViewModel;

class SkillGroup
{
    public function __construct(
        public string $label,
        public string $slug,
        /** @var DomainSkill[] */
        public array $skills
    ) {}
}
