<?php

namespace src\Presenter\ViewModel;

final class AbilityOptionView
{
    /**
     * @param AbilityView[] $abilities
     */
    public function __construct(
        public string $name,
        public string $description = '',
        public array $abilities = [],
    ) {}
}
