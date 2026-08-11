<?php
namespace src\Action;

use src\Action\Ajax\ActivateMapAction;
use src\Action\Ajax\AddMapTokenAction;
use src\Action\Ajax\DeleteMapTokenAction;
use src\Action\Ajax\LoadCreationStepSide;
use src\Action\Ajax\LoadMapTokensAction;
use src\Action\Ajax\LoadMapTokenModal;
use src\Action\Ajax\LoadMoreMonstersAction;
use src\Action\Ajax\LoadMoreSpellsAction;
use src\Action\Ajax\LockMapAction;
use src\Action\Ajax\ModalMonsterCard;
use src\Action\Ajax\UnlockMapAction;
use src\Action\Ajax\UpdateMapTokensAction;
use src\Constant\Constant as C;
use src\Factory\PresenterFactory;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Factory\WriterFactory as WF;
use src\Renderer\TemplateRenderer;

class AjaxRouter
{
    private array $actions = [
        'loadMoreSpells'       => LoadMoreSpellsAction::class,
        'loadMoreMonsters'     => LoadMoreMonstersAction::class,
        'modalMonsterCard'     => ModalMonsterCard::class,
        'loadCreationStepSide' => LoadCreationStepSide::class,
        'loadMapTokens'        => LoadMapTokensAction::class,
        'updateMapTokens'      => UpdateMapTokensAction::class,
        'getAddMapTokenModal'  => LoadMapTokenModal::class,
        'addMapToken'          => AddMapTokenAction::class,
        'deleteMapToken'       => DeleteMapTokenAction::class,
        'activateMap'          => ActivateMapAction::class,
        'lockMap'              => LockMapAction::class,
        'unlockMap'            => UnlockMapAction::class,
    ];

    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private WF $writerFactory,
        private TemplateRenderer $renderer,
        private PresenterFactory $presenterFactory,
    ) {}

    public function dispatch(string $ajaxAction, ?array $params): array
    {
        if (! isset($this->actions[$ajaxAction])) {
            return [
                'status'             => 'error',
                C::ACTION => $ajaxAction,
                'message'            => 'Unknown action',
            ];
        }

        $className = $this->actions[$ajaxAction];
        $action = match ($ajaxAction) {
            'addMapToken' => new $className(
                $this->writerFactory,
                $this->readerFactory,
                $this->serviceFactory,
            ),
            'deleteMapToken' => new $className(
                $this->writerFactory,
                $this->readerFactory,
                $this->serviceFactory,
            ),
            'updateMapTokens' => new $className(
                $this->writerFactory,
                $this->readerFactory,
                $this->serviceFactory,
            ),
            'activateMap' => new $className(
                $this->serviceFactory->map(),
            ),
            'getAddMapTokenModal' => new $className(
                $this->readerFactory,
                $this->presenterFactory,
            ),

            default => new $className(
                $this->readerFactory,
                $this->serviceFactory,
                $this->renderer
            ),
        };

        return [
            'status'             => 'success',
            C::ACTION => $ajaxAction,
            C::DATA   => $action->execute($params),
        ];
    }
}
