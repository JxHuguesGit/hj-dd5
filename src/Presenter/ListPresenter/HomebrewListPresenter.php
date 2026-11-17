<?php

namespace src\Presenter\ListPresenter;

use src\Constant\Routes as R;
use src\Collection\Collection;
use src\Presenter\ViewModel\HomebrewGroup;
use src\Presenter\ViewModel\HomebrewRow;

final class HomebrewListPresenter extends RuleListPresenter
{
    public function present(array $posts): Collection
    {
        return parent::rulePresent(
            HomebrewRow::class,
            HomebrewGroup::class,
            R::HOMEBREW_PREFIX,
            $posts
        );
    }

    protected function addSpecifics(&$row, \WP_Post $post): void
    {
        $row->new = has_tag('new', $post);
        $row->refonte = has_tag('refonte', $post);
    }
}
