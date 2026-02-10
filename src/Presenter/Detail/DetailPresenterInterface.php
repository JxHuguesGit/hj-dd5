<?php
namespace src\Presenter\Detail;

use src\Presenter\ViewModel\PageViewInterface;

interface DetailPresenterInterface
{
    public function present(PageViewInterface $viewData): array;
}

