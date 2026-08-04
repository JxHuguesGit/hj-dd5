<?php

namespace src\Presenter\ViewModel;

final readonly class OriginDetailView
{
    public function __construct(
        public string $name,
        public array $abilities,
        public iterable $skills,
        public string $description,
        public ?LinkView $feat,
        public ?LinkView $tool,
        public array $equipment,
        public ?LinkView $previous,
        public ?LinkView $next,
    ) {}
}
