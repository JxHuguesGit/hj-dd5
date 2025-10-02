<?php
namespace src\Action;

use src\Utils\Session;

class Ajax{

    public static function dealWithAjax()
    {
        $ajaxAction	= Session::fromPost('ajaxAction');
        switch ($ajaxAction) {
            case 'loadCasteDetail':
                $returnedValue = LoadCasteDetail::build();
            break;
            case 'downloadFile':
                $returnedValue = DownloadFile::start();
            break;
            case 'modalMonsterCard':
            	$returnedValue = MonsterCard::build();
            break;
            default:
                $returnedValue = 'default';
            break;
        }
        return '{"'.$ajaxAction.'": '.json_encode($returnedValue).'}';
    }
}