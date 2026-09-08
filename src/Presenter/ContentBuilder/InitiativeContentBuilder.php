<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Presenter\ViewModel\InitiativeRow;
use src\Utils\Html;

final class InitiativeContentBuilder implements ContentBuilderInterface
{
    private string $content = '';

    public function build(object $viewData): string
    {
        foreach ($viewData as $row) {
            $this->content .= $this->renderItem($row);
        }

        return $this->content;
    }

    public function buildHeader(object $combat): string
    {
        if (!$combat->active) {
            $strHeader = 'Préparatifs...';
            $this->content .= '<li class="initiative-item initiative-item--preparing"><span class="initiative-item__preparing-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-swords" aria-hidden="true"><polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"></polyline><line x1="13" x2="19" y1="19" y2="13"></line><line x1="16" x2="20" y1="16" y2="20"></line><line x1="19" x2="21" y1="21" y2="19"></line><polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5"></polyline><line x1="5" x2="9" y1="14" y2="18"></line><line x1="7" x2="4" y1="17" y2="20"></line><line x1="3" x2="5" y1="19" y2="21"></line></svg> Rencontre en préparation...</span></li>';
        } else {
            $strHeader = 'Round ' . $combat->round;
        }
        return $strHeader;
    }

    protected function getGroupClass(): string
    {
        return B::DATA_GROUP;
    }


    /** @param InitiativeRow $row */
    protected function renderItem(object $row): string
    {
        $activeClass = $row->active
            ? ' initiative-item--active'
            : '';
        $divArrow = $row->active
            ? '<span class="initiative-item__arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-right" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg>
                    </span>'
            : '';



        switch ($row->type) {
            case 'character' : //C::TYPE_PLAYER:
                $typeClass = ' lucide-shield initiative-item__type-icon--player';
                break;
            case 'npc' : //C::TYPE_NPC:
                $typeClass = ' lucide-user initiative-item__type-icon--npc';
                break;
            default:
                $typeClass = ' lucide-dragon initiative-item__type-icon--monster';
        }

        return sprintf(
            '<li class="initiative-item%s">
                <div class="initiative-item__left">
                    %s
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide initiative-item__type-icon%s" aria-hidden="true">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                    </svg>
                    <span class="initiative-item__name">%s</span>
                </div>
                <div class="initiative-item__right">
                    <span class="initiative-item__score">%s</span>
                </div>
            </li>',
            $activeClass,
            $divArrow,
            $typeClass,
            htmlspecialchars($row->name),
            $row->initiative
        );
    }
}
