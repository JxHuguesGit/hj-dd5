<?php
namespace src\Presenter\ViewModel;

final class FeatDetailView
{
    /** @param LinkView[] $origins */
    public function __construct(
        public string $name,
        public string $slug,
        public string $description,

        public FeatTypeView $type,
        public array $origins,

        public ?LinkView $previous,
        public ?LinkView $next,
    ) {}
}
