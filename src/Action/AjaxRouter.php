<?php
namespace src\Action;

use src\Action\Ajax\LoadMoreSpellsAction;
use src\Action\Ajax\LoadMoreMonstersAction;
use src\Action\Ajax\ModalMonsterCard;

class AjaxRouter
{
    private array $actions = [
        'loadMoreSpells' => LoadMoreSpellsAction::class,
        'loadMoreMonsters' => LoadMoreMonstersAction::class,
        'modalMonsterCard' => ModalMonsterCard::class,
    ];
    
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
        $action = new $className();
        
        return [
            'status' => 'success',
            'action' => $ajaxAction,
            'data' => $action->execute()
        ];
    }
}
