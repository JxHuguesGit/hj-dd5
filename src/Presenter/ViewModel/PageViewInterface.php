<?php
namespace src\Presenter\ViewModel;

interface PageViewInterface
{
    public function getSlug(): string;
    public function getName(): string;
}
