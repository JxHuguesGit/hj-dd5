<?php
namespace src\Action;

use src\Action\Ajax\LoadCreationStepSide;
use src\Action\Ajax\LoadMoreMonstersAction;
use src\Action\Ajax\LoadMoreSpellsAction;
use src\Action\Ajax\ModalMonsterCard;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;

class AjaxRouter
{
    private array $actions = [
        'loadMoreSpells' => LoadMoreSpellsAction::class,
        'loadMoreMonsters' => LoadMoreMonstersAction::class,
        'modalMonsterCard' => ModalMonsterCard::class,
        'loadCreationStepSide' => LoadCreationStepSide::class,
    ];

    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function dispatch(string $ajaxAction): array
    {
        if (!isset($this->actions[$ajaxAction])) {
            return [
                'status' => 'error',
                'action' => $ajaxAction,
                'message' => 'Unknown action'
            ];
        }

        $className = $this->actions[$ajaxAction];
        $action = new $className($this->readerFactory, $this->serviceFactory, $this->renderer);

        return [
            'status' => 'success',
            'action' => $ajaxAction,
            'data' => $action->execute()
        ];
    }
}
