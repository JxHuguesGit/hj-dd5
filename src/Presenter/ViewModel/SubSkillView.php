<?php

namespace src\Presenter\ViewModel;

final class SubSkillView
{
    public function __construct(
        public string $name,
        public string $slug,
        public string $description
    ) {}
}
