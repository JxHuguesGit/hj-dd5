<?php

namespace src\Presenter\ViewModel;

final class SkillDetailView
{
    /**
     * @param SkillLink[] $origins
     * @param SubSkillView[] $subSkills
     */
    public function __construct(
        public string $name,
        public string $ability,
        public string $description,
        public array $origins,
        public array $subSkills,
        public ?LinkView $previous,
        public ?LinkView $next
    ) {}
}
