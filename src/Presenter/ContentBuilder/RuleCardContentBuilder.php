<?php

namespace src\Presenter\ContentBuilder;

use Override;
use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Service\Domain\WpPostService;
use src\Utils\Html;

final class RuleCardContentBuilder
extends AbstractCardContentBuilder
{
    public function __construct()
    {
        // In progress
    }

    public function build(object $groups): string
    {
        return '';
    }

    protected function renderItem(object $row): string
    {
        return '';
    }
}
