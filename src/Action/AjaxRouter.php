<?php

namespace src\Action;

use src\Action\Ajax\ActivateMapAction;
use src\Action\Ajax\AddCreatureToCombatAction;
use src\Action\Ajax\AddMapTokenAction;
use src\Action\Ajax\AddTokenAction;
use src\Action\Ajax\DeleteMapAction;
use src\Action\Ajax\DeleteMapTokenAction;
use src\Action\Ajax\DuplicateMapAction;
use src\Action\Ajax\InitiativeTracker\DealWithInitTracker;
use src\Action\Ajax\InitiativeTracker\ITRefreshPlayerView;
use src\Action\Ajax\LoadCombatAction;
use src\Action\Ajax\LoadCombatMonstersAction;
use src\Action\Ajax\LoadCreationStepSide;
use src\Action\Ajax\LoadMapTokensAction;
use src\Action\Ajax\LoadMapTokenModal;
use src\Action\Ajax\LoadTokenModal;
use src\Action\Ajax\LoadMoreMonstersAction;
use src\Action\Ajax\LoadMoreSpellsAction;
use src\Action\Ajax\LockMapAction;
use src\Action\Ajax\ModalMonsterCard;
use src\Action\Ajax\RemoveCreatureFromCombatAction;
use src\Action\Ajax\ResetMapFogAction;
use src\Action\Ajax\ToggleMapTokenAction;
use src\Action\Ajax\UnlockMapAction;
use src\Action\Ajax\UpdateCombatParticipantAction;
use src\Action\Ajax\UpdateMapTokensAction;
use src\Constant\Constant as C;
use src\Factory\AjaxActionFactory;

class AjaxRouter
{
    private array $actions = [
        'loadMoreSpells'                    => LoadMoreSpellsAction::class,
        'loadMoreMonsters'                  => LoadMoreMonstersAction::class,
        'modalMonsterCard'                  => ModalMonsterCard::class,
        'loadCreationStepSide'              => LoadCreationStepSide::class,
        'loadMapTokens'                     => LoadMapTokensAction::class,
        'updateMapTokens'                   => UpdateMapTokensAction::class,
        'getAddMapTokenModal'               => LoadMapTokenModal::class,
        'getAddTokenModal'                  => LoadTokenModal::class,
        'addMapToken'                       => AddMapTokenAction::class,
        'toggleMapToken'                    => ToggleMapTokenAction::class,
        'addToken'                          => AddTokenAction::class,
        'deleteMapToken'                    => DeleteMapTokenAction::class,
        'activateMap'                       => ActivateMapAction::class,
        'lockMap'                           => LockMapAction::class,
        'unlockMap'                         => UnlockMapAction::class,
        'duplicateMap'                      => DuplicateMapAction::class,
        'deleteMap'                         => DeleteMapAction::class,
        'resetMapFog'                       => ResetMapFogAction::class,
        'loadCombatMonsters'                => LoadCombatMonstersAction::class,
        'loadCombat'                        => LoadCombatAction::class,
        'addCreatureToCombat'               => AddCreatureToCombatAction::class,
        'removeCreatureFromCombat'          => RemoveCreatureFromCombatAction::class,
        'rerollCombatParticipantInitiative' => UpdateCombatParticipantAction::class,
        'refreshPlayerView'                 => ITRefreshPlayerView::class,
        'addInitChar'                       => DealWithInitTracker::class,
        'addInitCharToCombat'               => DealWithInitTracker::class,
        'rmvInitCharToCombat'               => DealWithInitTracker::class,
        'addMonsterToCombat'                => DealWithInitTracker::class,
        'delInitChar'                       => DealWithInitTracker::class,
        'updateInitChar'                    => DealWithInitTracker::class,
        'toggleReaction'                    => DealWithInitTracker::class,
        'toggleReady'                       => DealWithInitTracker::class,
        'setInitChar'                       => DealWithInitTracker::class,
        'nextCombatChar'                    => DealWithInitTracker::class,
        'prevCombatChar'                    => DealWithInitTracker::class,
        'endCombat'                         => DealWithInitTracker::class,
        'startCombat'                       => DealWithInitTracker::class,
        'dealDamage'                        => DealWithInitTracker::class,
        'heal'                              => DealWithInitTracker::class,
        'setTempHP'                         => DealWithInitTracker::class,
    ];

    public function __construct(
        private AjaxActionFactory $actionFactory,
    ) {}

    public function supports(string $ajaxAction): bool
    {
        return isset($this->actions[$ajaxAction]);
    }

    public function dispatch(string $ajaxAction, ?array $params): array
    {
        if (! isset($this->actions[$ajaxAction])) {
            return [
                'status'             => 'error',
                C::ACTION => $ajaxAction,
                'message'            => 'Unknown action',
            ];
        }

        $action = $this->actionFactory->make($this->actions[$ajaxAction]);

        return array_merge([C::ACTION => $ajaxAction], $action->execute($params));
    }
}
