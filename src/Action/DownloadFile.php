<?php
namespace src\Action;

use src\Controller\Utilities;
use src\Utils\Session;

class DownloadFile
{
    public static function start(): string
    {
        $source = Session::fromPost('source');
        $uktag = Session::fromPost('uktag');

        $urlSource = 'https://www.' . $source . '.org/monster/' . $uktag;
        $content = file_get_contents($urlSource);

        $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$uktag.'.html';
        file_put_contents($urlDestination, $content);

        return '';
    }

}
