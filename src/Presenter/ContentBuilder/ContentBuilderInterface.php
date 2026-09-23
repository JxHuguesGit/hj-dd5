<?php

namespace src\Presenter\ContentBuilder;

interface ContentBuilderInterface
{
    /**
     * @param object $data
     */
    public function build(object $data): string;
}
