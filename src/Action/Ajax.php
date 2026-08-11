<?php
namespace src\Action;

use src\Constant\Constant as C;
use src\Factory\PresenterFactory;
use src\Factory\ReaderFactory;
use src\Factory\RepositoryFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

if (strpos(PLUGIN_PATH, 'wamp64') !== false) {
    define('DD5_URL', 'http://localhost/');
} else {
    define('DD5_URL', 'https://dd5.jhugues.fr/');
}
define('PLUGIN_URL', 'wp-content/plugins/hj-dd5/');
define('PLUGINS_DD5', DD5_URL . PLUGIN_URL);

class Ajax
{

    public static function dealWithAjax()
    {
        $ajaxAction = Session::fromPost(C::AJAXACTION);
        $mapId = (int)Session::fromPost(C::MAPID);

        $actions = [
            'downloadFile'    => fn()    => DownloadFile::start(),
            'loadCasteDetail' => fn() => LoadCasteDetail::build(),
            'modalFeatCard'   => fn()   => FeatCard::build(),
            'modalSpellCard'  => fn()  => SpellCard::build(),
        ];
        try {
            if (in_array(
                $ajaxAction,
                [
                    'loadMoreSpells',
                    'loadMoreMonsters',
                    'modalMonsterCard',
                    'loadCreationStepSide',
                    'loadMapTokens',
                    'updateMapTokens',
                    'getAddMapTokenModal',
                    'addMapToken',
                    'deleteMapToken',
                    'activateMap',
                    'lockMap',
                    'unlockMap',
                ]
            )) {
                $queryBuilder          = new QueryBuilder();
                $queryExecutor         = new QueryExecutor();
                $repository            = new RepositoryFactory($queryBuilder, $queryExecutor);
                $reader                = new ReaderFactory($repository);
                $writer                = new WF($repository);
                $router                = new AjaxRouter(
                    $reader,
                    new ServiceFactory($reader, $repository),
                    $writer,
                    new TemplateRenderer(),
                    new PresenterFactory()
                );
                $response              = $router->dispatch(
                    $ajaxAction,
                    [C::MAPID => $mapId]
                );
                $response[$ajaxAction] = $response[C::DATA];
            } elseif (isset($actions[$ajaxAction])) {
                $returnedValue = $actions[$ajaxAction];

                $response = [
                    // A terme, supprimer cet élément
                    $ajaxAction          => $returnedValue,
                    // Fin suppression
                    'status'             => 'success',
                    C::ACTION => $ajaxAction,
                    C::DATA   => $returnedValue,
                ];
            } else {
                $response = [
                    $ajaxAction          => 'default',
                    'status'             => 'error',
                    C::ACTION => $ajaxAction,
                    'message'            => 'default',
                ];
            }
        } catch (\Throwable $e) {
            $response = [
                // A terme, supprimer cet élément
                $ajaxAction          => 'default',
                // Fin suppression
                'status'             => 'error',
                C::ACTION => $ajaxAction,
                'message'            => $e->getMessage(),
            ];
        }

        return json_encode($response);
    }

}
