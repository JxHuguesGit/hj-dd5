<?php

namespace src\Presenter\ListPresenter;

use src\Constant\Routes as R;
use src\Collection\Collection;
use src\Presenter\ViewModel\GlossaireGroup;
use src\Presenter\ViewModel\GlossaireRow;

final class GlossaireListPresenter extends RuleListPresenter
{
    public function present(array $posts): Collection
    {
        return parent::rulePresent(
            GlossaireRow::class,
            GlossaireGroup::class,
            R::GLOSSARY_PREFIX,
            $posts
        );
    }
}
