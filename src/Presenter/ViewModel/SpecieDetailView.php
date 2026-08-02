<?php
namespace src\Presenter\ViewModel;

final class SpecieDetailView
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,

        public string $creatureType,
        public string $sizeCategory,
        public string $speed,

        /** @var AbilityView[] */
        public array $abilities,

        public ?LinkView $previous,
        public ?LinkView $next,
    ) {}
}
