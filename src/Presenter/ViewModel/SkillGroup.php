<?php
namespace src\Presenter\ViewModel;

final class SkillGroup
{
    /**
     * @param SkillRow[] $rows
     */
    public function __construct(
        public string $label,
        public string $slug,
        public array $rows
    ) {}
}
