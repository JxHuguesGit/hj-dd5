<?php

namespace src\Presenter\ContentBuilder;

use src\Presenter\TableBuilder\TableBuilderInterface;

final class TableContentBuilder implements ContentBuilderInterface
{
    public function __construct(
        private TableBuilderInterface $tableBuilder
    ) {}

    public function build(iterable $data, array $params = []): string
    {
        return $this->tableBuilder
            ->build($data, $params)
            ->display();
    }
}