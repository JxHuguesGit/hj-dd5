<?php
namespace src\Presenter\ViewModel;

final class FeatTypeView
{
    public function __construct(
        public string $label,
        public string $slug,
        public ?string $prerequisite = null,
    ) {}
}
