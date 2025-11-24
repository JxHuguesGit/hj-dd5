<?php
namespace src\Action;

use src\Utils\Session;

class Ajax{

    public static function dealWithAjax()
    {
        $ajaxAction    = Session::fromPost('ajaxAction');
        switch ($ajaxAction) {
            case 'loadCreationStepSide':
                $type    = Session::fromPost('type');
                $id      = Session::fromPost('id');
                $returnedValue = LoadCreationStepSide::build($type, $id);
            break;
            case 'loadCasteDetail':
                $returnedValue = LoadCasteDetail::build();
            break;
            case 'downloadFile':
                $returnedValue = DownloadFile::start();
            break;
            case 'modalFeatCard':
                $returnedValue = FeatCard::build();
            break;
            case 'modalMonsterCard':
                $returnedValue = MonsterCard::build();
            break;
            case 'modalSpellCard':
                $returnedValue = SpellCard::build();
            break;
            default:
                $returnedValue = 'default';
            break;
        }
        return '{"'.$ajaxAction.'": '.json_encode($returnedValue).'}';
    }
    
}
