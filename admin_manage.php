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
use src\Factory\Admin\AdminSidebarFactory;
use src\Factory\Admin\AdminContentFactory;
use src\Factory\CompendiumFactory;
use src\Factory\PresenterFactory;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Factory\ServiceFactory;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
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
        /////////////////////////////////////////
        // Analyse de l'url
        $uri = Session::fromServer('REQUEST_URI');
        $arrUri = explode('/', $uri);

        $qb       = new QueryBuilder();
        $qe       = new QueryExecutor();
        $repositoryFactory = new RepositoryFactory($qb, $qe);
        $readerFactory = new ReaderFactory($repositoryFactory);

        $adminPage = new AdminPage(
            $arrUri,
            new AdminSidebarFactory($readerFactory),
            new AdminContentFactory(
                new CompendiumFactory(
                    $qb,
                    $qe,
                    new TemplateRenderer()
                ),
                new ServiceFactory($readerFactory, $repositoryFactory),
                $readerFactory,
                new PresenterFactory()
            ),
        );
        echo $adminPage->getAdminContentPage();
    }
}
DD5Admin::display();
