<?php
namespace src\Controller;

use src\Constant\Template;

class AdminHomePage extends AdminPage
{
    public function getAdminContentPage(string $content=''): string
    {
        $content .= 'AdminHomePage::getAdminContentPage WIP';
        return parent::getAdminContentPage($content);
    }
}
