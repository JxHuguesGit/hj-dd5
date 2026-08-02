<?php
namespace src\Presenter\TableBuilder;

use src\Utils\Table;

interface TableBuilderInterface
{
    public function build(object $groups, array $params = []): Table;
}
