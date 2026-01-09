<?php
namespace src\Presenter\TableBuilder;

use src\Utils\Table;

interface TableBuilderInterface
{
    public function build(iterable $items, array $options = []): Table;
}
