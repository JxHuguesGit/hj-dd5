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

        if (substr($uktag, 0, 3)=='fr-') {
            $urlSource = 'https://www.' . $source . '.org/monster/fr/' . substr($uktag, 0, 3);
        } else {
            $urlSource = 'https://www.' . $source . '.org/monster/' . $uktag;
        }
        $content = file_get_contents($urlSource);

        $urlDestination = '../wp-content/plugins/hj-dd5/assets/aidedd/'.$uktag.'.html';
        file_put_contents($urlDestination, $content);

        return '';
    }

}
