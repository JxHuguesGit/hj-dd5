<?php
namespace src\Presenter\Admin;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Collection\Collection;
use src\Domain\Entity\InitiativeTracker;
use src\Domain\Entity\Map;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class InitiativeAdminPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function presentInitiativePanel(): string
    {
        $combatId = filter_input(
            INPUT_GET,
            'combatId',
            FILTER_VALIDATE_INT
        );

        // Vérification existence d'un rpgInitiativeTracker avec id=combatId.
        // Si pas de correspondance, on renvoie à la liste des IT disponibles.
        $initiativeTracker = $this->mock();

        return $this->renderer->render(
            T::ADMININITIATIVEPANEL,
            [
                PLUGINS_DD5,
                date('YmdHis'),
                $this->buildITHeader($initiativeTracker),
                $this->buildITPartyAside($initiativeTracker),
                $this->buildITEnnemyAside($initiativeTracker),
                // Présence de combattants ? Combat en cours ?
                !$initiativeTracker->partyMembers->isEmpty() ? 'has-combatants active-combat' : '',
                $this->buildITHeaderPanel($initiativeTracker),
                $this->buildIdContentPanel($initiativeTracker),
            ]
        );
    }

    private function mock(): InitiativeTracker
    {
        $mock = new InitiativeTracker();
        $mock->name = 'MockName';
        $mock->ITCode = 'AZERTY';
        $mock->round = 0;
        $mock->partyMembers = new Collection();
        $mock->ennemyMembers = new Collection();
        return $mock;
    }

    private function buildITHeader(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_HEADER,
            [
                $initiativeTracker->name,
                $initiativeTracker->ITCode,
                date('H:i'),
            ]
        );
    }

    private function buildITPartyAside(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_PARTY_ASIDE,
            [
                // Si aucun personnage listé, on ne peut pas monter de niveau.
                $initiativeTracker->partyMembers->isEmpty() ? C::DISABLED : '',
                // Si aucun personnage listé, on affiche le message "Pas de participants".
                $initiativeTracker->partyMembers->isEmpty() ? '' : B::DNONE,
                // On affiche la liste des personnages listés
                '',
            ]
        );
    }

    private function buildITEnnemyAside(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_ENNEMY_ASIDE,
            [
                // On affiche la liste des ennemis disponibles
                '',
            ]
        );

    }

    private function buildITHeaderPanel(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_HEADER_PANEL,
            [
                // Numéro du round
                $initiativeTracker->round,
            ]
        );
    }

    private function buildIdContentPanel(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_CONTENT_PANEL,
            [

            ]
        );
    }









    public function present(Map $map, Collection $mapTokens, Collection $initiatives): string
    {
        $mapTokensFormatted = $this->presentMapTokens($mapTokens, $initiatives);
        $initiativesFormatted = 'wip initiativesFormatted';

        return $this->renderer->render(
            T::ADMINTIMELINE,
            [
                htmlspecialchars($map->name, ENT_QUOTES),
                UrlGenerator::admin('map', 'maps'),
                UrlGenerator::admin('map', 'maps', '', '', ['mapId' => $map->id]),
                $mapTokensFormatted,
                $initiativesFormatted
            ]
        );
    }

    private function presentMapTokens(
        Collection $mapTokens,
        Collection $initiatives
    ): string {
        $initiativeTokenIds = [];

        foreach ($initiatives as $initiative) {
            $initiativeTokenIds[] = $initiative->mapTokenId;
        }

        $html = '';

        foreach ($mapTokens as $mapToken) {
            $isInInitiative = in_array(
                $mapToken->id,
                $initiativeTokenIds,
                true
            );

            $html .= '<tr>' .
            // Visuel du token
            Html::getBalise(
                H::BALISE_TD,
                Html::getBalise(
                    H::BALISE_IMG,
                    '',
                    [
                        C::CSSCLASS => 'map-token-image',
                        'src' => PLUGINS_DD5 . 'assets/map/tokens/' . htmlspecialchars($mapToken->image, ENT_QUOTES)
                    ]
                )
            ) .
            // Position
            Html::getBalise(
                H::BALISE_TD,
                $mapToken->column . ', ' . $mapToken->row
            ) .
            // Numéro
            Html::getBalise(
                H::BALISE_TD,
                $mapToken->number
            ) .
            // Action
            Html::getBalise(
                H::BALISE_TD,
                Html::getButton(
                    Html::getIcon(I::MINUS) . Html::getIcon(I::PLUS),
                    [
                        C::CSSCLASS => 'btn btn-sm ' . ($isInInitiative ? 'btn-danger' : 'btn-success'),
                        C::TITLE => ($isInInitiative ? 'Retirer' : 'Ajouter') . ' de l\'initiative',
                    ]
                ),
                [
                    C::CSSCLASS => 'map-token' . ($isInInitiative ? ' inactive' : '')
                ]
            );
        }

        return $html;
    }
}
