<?php

namespace src\Presenter\ContentBuilder;

interface ContentBuilderInterface
{
    public function build(object $data): string;
}
