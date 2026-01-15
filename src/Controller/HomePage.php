<?php
namespace src\Controller;

use src\Constant\Template;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicHome;

class HomePage extends Utilities
{

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Home';
    }

    public function getContentPage(string $msgProcessError=''): string
    {
        return $this->getRender(Template::WIP_PAGE, []);
    }

    public static function getController(): PublicBase
    {
        return new PublicHome();
    }
}
