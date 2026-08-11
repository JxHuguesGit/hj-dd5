<?php
namespace src\Controller\Admin;

use src\Controller\AdminPage;

class AdminTimelinePage extends AdminPage
{
    public function getAdminContentPage(string $content = ''): string
    {
        return parent::getAdminContentPage('Hello Initiative');
    }
}
