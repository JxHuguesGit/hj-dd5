<?php
namespace src\Presenter\TableBuilder;

use src\Utils\Table;

interface TableBuilderInterface
{
    public function build(iterable $groups, array $params = []): Table;
}
