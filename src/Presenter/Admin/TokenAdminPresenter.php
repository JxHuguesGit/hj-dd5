<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Domain\Entity\Token;
use src\Domain\Monster\Monster;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;

final class TokenAdminPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    /**
     * @param iterable<Token> $tokens
     */
    public function present(iterable $tokens): string
    {
        $rows = '';

        foreach ($tokens as $token) {
            $strImage = Html::getBalise(
                H::BALISE_IMG,
                '',
                [
                    'src' => PLUGINS_DD5 . '/assets/map/tokens/' . $token->image,
                    'alt' => $token->image,
                    C::CSSCLASS => 'admin-token-image'
                ]
            );

            $association = $token->entityId;
            $strEditButton = Html::getButton(
                Html::getIcon(I::EDIT),
                [
                    C::CSSCLASS => 'btn-primary ajaxAction',
                    C::TITLE => 'Modifier le token',
                    C::DATA => [
                        C::TRIGGER => C::CLICK,
                        C::ACTION => 'editToken',
                        'token-id' => $token->id
                    ]
                ]
            );

            $strDeleteButton = Html::getButton(
                Html::getIcon(I::TRASHALT),
                [
                    C::CSSCLASS => 'btn-danger ajaxAction',
                    C::TITLE => 'Supprimer le token',
                    C::DATA => [
                        C::TRIGGER => C::CLICK,
                        C::ACTION => 'deleteToken',
                        'token-id' => $token->id
                    ]
                ]
            );

            $actions = $strEditButton . ' ' . $strDeleteButton;

            $row =
                Html::getBalise(H::BALISE_TD, $strImage) .
                Html::getBalise(H::BALISE_TD, htmlspecialchars($token->name)) .
                Html::getBalise(H::BALISE_TD, htmlspecialchars($token->type)) .
                Html::getBalise(H::BALISE_TD, $token->size) .
                Html::getBalise(H::BALISE_TD, $association) .
                Html::getBalise(H::BALISE_TD, $token->active ? 'Oui' : 'Non') .
                Html::getBalise(
                    H::BALISE_TD,
                    $actions,
                    [C::CSSCLASS => 'admin-token-actions']
                );

            $rows .= Html::getBalise(
                H::BALISE_TR,
                $row,
                [
                    C::CSSCLASS => 'admin-token',
                    C::DATA => ['token-id' => $token->id]
                ]
            );
        }

        return $this->renderer->render(
            T::ADMINTOKENTABLE,
            [$rows]
        );
    }

    /**
     * @param iterable<Token> $tokens
     */
    public function presentAddModal(iterable $tokens): string
    {
        $strOptions = '';
        foreach ($tokens as $token) {
            $strOptions .= Html::getOption(htmlspecialchars($token->name, ENT_QUOTES), ['value' => $token->id]);
        }

        return $this->renderer->render(
            T::ADDMAPTOKMODAL,
            [$strOptions]
        );
    }

    /**
     * @param iterable<Monster> $monsters
     */
    public function presentAddTokenModal(iterable $monsters): string
    {
        $strOptions = '';

        foreach ($monsters as $monster) {
            $strOptions .= Html::getOption(
                htmlspecialchars($monster->name, ENT_QUOTES),
                [
                    'value' => $monster->id,
                    'data-size' => $monster->monsterSize,
                ]
            );
        }

        return $this->renderer->render(
            T::ADDTOKENMODAL,
            [$strOptions]
        );
    }
}
