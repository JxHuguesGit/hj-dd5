<?php
namespace src\Action;

use src\Utils\Session;

class Ajax{

    public static function dealWithAjax()
    {
        $ajaxAction    = Session::fromPost('ajaxAction');

        $actions = [
            'downloadFile' => fn() => DownloadFile::start(),
            'loadCasteDetail' => fn() => LoadCasteDetail::build(),
            'loadCreationStepSide' => fn() => LoadCreationStepSide::build(Session::fromPost('type'), Session::fromPost('id')),
            'modalFeatCard' => fn() => FeatCard::build(),
            'modalMonsterCard' => fn() => MonsterCard::build(),
            'modalSpellCard' => fn() => SpellCard::build(),
        ];
        try {
            if (in_array($ajaxAction, ['loadMoreSpells', 'loadMoreMonsters'])) {
                $router = new AjaxRouter();
                $response = $router->dispatch($ajaxAction);
                $response[$ajaxAction] = $response['data'];
            } elseif (isset($actions[$ajaxAction])) {
                $returnedValue = $actions[$ajaxAction];

                $response = [
                    // A terme, supprimer cet élément
                    $ajaxAction => $returnedValue,
                    // Fin suppression
                    'status' => 'success',
                    'action' => $ajaxAction,
                    'data'   => $returnedValue
                ];
            } else {
                $response = [
                    $ajaxAction => 'default',
                    'status' => 'error',
                    'action' => $ajaxAction,
                    'message' => 'default'
                ];
            }
        } catch (\Throwable $e) {
            $response = [
                // A terme, supprimer cet élément
                $ajaxAction => 'default',
                // Fin suppression
                'status' => 'error',
                'action' => $ajaxAction,
                'message' => $e->getMessage()
            ];
        }

        return json_encode($response);
    }
    
}
