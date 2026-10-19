<?php
namespace src\Action;

use src\Utils\Session;

class DownloadFile
{
    public static function start(): string
    {
        $source = Session::fromPost('source');
        $uktag = Session::fromPost('uktag');

        $allowedSources = ['aidedd'];
        if (!in_array($source, $allowedSources, true)) {
            return 'Source invalide';
        }

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
