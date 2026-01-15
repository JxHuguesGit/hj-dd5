<?php
namespace src\Presenter\ViewModel;

final class SkillRow
{
    public function __construct(
        public string $name,
        public string $url,
        public string $description,
        public string $subSkills
    ) {}
}
