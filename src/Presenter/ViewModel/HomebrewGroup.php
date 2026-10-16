<?php

namespace src\Presenter\ViewModel;

final class HomebrewGroup
{
    public string $slug = 'homebrew';
    public string $label = '';

    /** @var HomebrewRow[] */
    public array $rows = [];
}
