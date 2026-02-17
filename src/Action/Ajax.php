<?php
namespace src\Action;

use src\Constant\Constant;
use src\Utils\Session;

class Ajax{

    public static function dealWithAjax()
    {
        $ajaxAction    = Session::fromPost(Constant::CST_AJAXACTION);

        $actions = [
            'downloadFile' => fn() => DownloadFile::start(),
            'loadCasteDetail' => fn() => LoadCasteDetail::build(),
            'loadCreationStepSide' => fn() => LoadCreationStepSide::build(Session::fromPost(Constant::CST_TYPE), Session::fromPost(Constant::CST_ID)),
            'modalFeatCard' => fn() => FeatCard::build(),
            'modalSpellCard' => fn() => SpellCard::build(),
        ];
        try {
            if (in_array(
                $ajaxAction,
                [
                    'loadMoreSpells',
                    'loadMoreMonsters',
                    'modalMonsterCard'
                ]
            )) {
                $router = new AjaxRouter();
                $response = $router->dispatch($ajaxAction);
                $response[$ajaxAction] = $response[Constant::CST_DATA];
            } elseif (isset($actions[$ajaxAction])) {
                $returnedValue = $actions[$ajaxAction];

                $response = [
                    // A terme, supprimer cet élément
                    $ajaxAction => $returnedValue,
                    // Fin suppression
                    'status' => 'success',
                    Constant::CST_ACTION => $ajaxAction,
                    Constant::CST_DATA   => $returnedValue
                ];
            } else {
                $response = [
                    $ajaxAction => 'default',
                    'status' => 'error',
                    Constant::CST_ACTION => $ajaxAction,
                    'message' => 'default'
                ];
            }
        } catch (\Throwable $e) {
            $response = [
                // A terme, supprimer cet élément
                $ajaxAction => 'default',
                // Fin suppression
                'status' => 'error',
                Constant::CST_ACTION => $ajaxAction,
                'message' => $e->getMessage()
            ];
        }

        return json_encode($response);
    }
    
}
