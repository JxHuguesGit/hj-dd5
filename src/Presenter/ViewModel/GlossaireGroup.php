<?php

namespace src\Presenter\ViewModel;

final class GlossaireGroup
{
    public string $slug = 'glossary';
    public string $label = '';

    /** @var GlossaireRow[] */
    public array $rows = [];
}
