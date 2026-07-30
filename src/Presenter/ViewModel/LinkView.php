<?php

namespace src\Presenter\ViewModel;

final class LinkView
{
    public function __construct(
        public string $name,
        public string $slug
    ) {}
}
