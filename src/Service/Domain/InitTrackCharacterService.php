<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Domain\Entity\ITCharacter;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\InitTrackCharacterReader;
use src\Service\Writer\InitTrackCharacterWriter;

final class InitTrackCharacterService
{
    public function __construct(
        private InitTrackCharacterReader $itCharacterReader,
        private InitTrackCharacterWriter $writerITChar,
        private TemplateRenderer $renderer,
    ) {}

    public function getTurnOrder(
        InitiativeTracker $initiativeTracker
    ): Collection
    {
        // On récupère la liste des personnages par initiative décroissante.
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE=>C::DESC];
        $iTCharacters = $this->itCharacterReader->allItCharacters($criteria);

        $queue = false;
        $orderedQueue = new Collection();
        $alreadyPlayed = new Collection();
        foreach ($iTCharacters as $itCharacter) {
            if ($queue) {
                $orderedQueue->add($itCharacter);
            } elseif ($itCharacter->id==$initiativeTracker->currentParticipantId) {
                $queue = true;
                $orderedQueue->add($itCharacter);
            } else {
                $alreadyPlayed->add($itCharacter);
            }
        }
        foreach ($alreadyPlayed as $character) {
            $orderedQueue->add($character);
        }
        return $orderedQueue;
    }

    public function displayCharacter(ITCharacter $character): string
    {
        $characterName = $character->name;
        $characterType = $character->characterType;
        $isPlayer      = $characterType == 'player';
        $libelleType   = $isPlayer ? 'Allié' : 'Ennemi';
        $initiative    = floor($character->initiative);
        $classeArmure  = $character->ac;

        return $this->renderer->render(
            T::PUBLIC_FRONT_ITCHAR,
            [
                $characterType,
                $libelleType,
                $isPlayer ? B::DNONE : '',
                'Image représentant ' . $characterName,
                '',//https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg
                $characterName,
                $initiative,
                $classeArmure,
            ]
        );
    }

    public function displayQueuedCharacters(Collection $queuedCharacters): string
    {
        $content = '';
        $actual = $queuedCharacters->first();
        $previousInitiative = $actual->initiative;
        $displayedCharacters = $queuedCharacters->slice(1, 4);

        foreach ($displayedCharacters as $character) {
            if (null!==$previousInitiative && $character->initiative > $previousInitiative) {
                $content .= $this->addNewRound();
            }
            $previousInitiative = $character->initiative;
            $content .= $this->displayQueuedCharacter($character);
        }
        return $content;
    }

    public function rollInitiative(int $initTrackerId): int
    {
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initTrackerId;
        $iTCharacters = $this->itCharacterReader->allItCharacters($criteria);
        $max = -10;
        $curCharId = -1;
        foreach ($iTCharacters as $character) {
            $initiative = rand(1, 20) + $character->modDex;
            if ($initiative>$max) {
                $max = $initiative;
                $curCharId = $character->id;
            }
            $character->initiative = $initiative;
            $this->writerITChar->updatePartial($character, [F::INITIATIVE]);
        }
        return $curCharId;
    }

    private function addNewRound(): string
    {
        return $this->renderer->render(
            T::PUBLIC_QUEUED_NEWROUND,
            []
        );
    }

    private function displayQueuedCharacter(ITCharacter $character): string
    {
        if ($character->characterType == 'monster') {
            $characterType = 'npc';
            $badgeTitle = 'PNJ — Personnage Non-Joueur';
            $badgeLabel = 'PNJ';
        } else {
            $characterType = 'pc';
            $badgeTitle = 'PJ — Personnage Joueur';
            $badgeLabel = 'PJ';
        }

        $libelleType   = $character->name;
        $initiative    = floor($character->initiative);

        return $this->renderer->render(
            T::PUBLIC_QUEUED_ITCHAR,
            [
                $characterType,
                $libelleType,
                '',//https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg
                $badgeTitle,
                $badgeLabel,
                $initiative,
            ]
        );
    }



}
