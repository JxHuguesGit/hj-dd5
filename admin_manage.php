        <!-- Bootstrap style -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
            integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
            crossorigin="anonymous">
        <!-- Font Awesome Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
<?php
use src\Controller\AdminPage;
use src\Domain\Entity;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Session;

if (strpos(PLUGIN_PATH, 'wamp64')!==false) {
    define('DD5_SITE_URL', 'http://localhost/');
} else {
    define('DD5_SITE_URL', 'https://dd5.jhugues.fr/');
}
define('PLUGINS_DD5', DD5_SITE_URL.'wp-content/plugins/hj-dd5/');
date_default_timezone_set('Europe/Paris');

class DD5Admin
{
    public static function display(): void
    {
        Entity::setSharedDependencies(new QueryBuilder(), new QueryExecutor());

        /////////////////////////////////////////
        // Analyse de l'url
        $uri = Session::fromServer('REQUEST_URI');
        $arrUri = explode('/', $uri);

        $controller = AdminPage::getAdminController($arrUri);

        echo $controller->getAdminContentPage();
    }
}
DD5Admin::display();
