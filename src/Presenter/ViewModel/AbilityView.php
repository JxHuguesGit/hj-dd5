<?php
namespace src\Presenter\ViewModel;

final class AbilityView
{
    /**
     * @param AbilityView[] $children
     * @param AbilityOptionView[] $options
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public array $children = [],
        public array $options = [],
    ) {}
}
