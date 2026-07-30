<?php

namespace src\Presenter\ContentBuilder;

interface ContentBuilderInterface
{
    public function build(object $data, array $params = []): string;
}
