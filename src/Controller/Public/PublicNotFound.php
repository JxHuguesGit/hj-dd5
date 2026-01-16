<?php
namespace src\Controller\Public;

use src\Page\PageNotFound;
use src\Presenter\MenuPresenter;

class PublicNotFound extends PublicBase
{
    public function __construct(
        private PageNotFound $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = 'Page non trouvée';
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('');
        return $this->page->render($menu, []);
    }
}
