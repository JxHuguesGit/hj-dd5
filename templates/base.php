<?php

use src\Constant\Constant;
use src\Constant\Template;
use src\Controller\Hero;
use src\Controller\HomePage;
use src\Controller\PublicBase;
use src\Controller\PublicHome;
use src\Controller\Utilities;
use src\Model\PageElement;
use src\Model\PageRegistry;
use src\Page\PageHome;
use src\Page\PageOrigines;
use src\Router\Router;
use src\Utils\Session;

if (strpos(PLUGIN_PATH, 'wamp64')!==false) {
    define('DD5_URL', 'http://localhost/');
} else {
    define('DD5_URL', 'https://dd5.jhugues.fr/');
}
define('PLUGIN_URL', 'wp-content/plugins/hj-dd5/');
define('PLUGINS_DD5', DD5_URL.PLUGIN_URL);
date_default_timezone_set('Europe/Paris');

class DD5Base
{
    public static function display(): void
    {
        $registry = PageRegistry::getInstance();

        $msgProcessError = '';
        $errorPanel = '';
        $controller = Router::getController();

        if (DD5_URL=='http://localhost/') {
            $srcCssFilesTpl = $controller->getRender(Template::LOCAL_CSS, [PLUGINS_DD5]);
            $srcJsFilesTpl = $controller->getRender(Template::LOCAL_JS, [PLUGINS_DD5]);
        } else {
            $srcCssFilesTpl = $controller->getRender(Template::WWW_CSS);
            $srcJsFilesTpl = $controller->getRender(Template::WWW_JS);
        }

        $attributes = [
            $controller->getTitle(),
            $srcCssFilesTpl,
            PLUGINS_DD5,
            $controller->getContentHeader(),
            $controller->getContentPage($msgProcessError),
            $controller->getContentFooter(),
            $errorPanel,
            $srcJsFilesTpl,
        ];
        echo $controller->getRender(Template::BASE, $attributes);
    }

}
DD5Base::display();