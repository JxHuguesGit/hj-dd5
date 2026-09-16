<?php
namespace src\Presenter\ViewModel;

final class SkillRow
{
    /**
     * @param SkillLink[] $subSkills
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $url,
        public string $description,
        public array $subSkills
    ) {}
}
