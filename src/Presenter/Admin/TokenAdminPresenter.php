<?php
namespace src\Presenter\Admin;

use src\Constant\Template as T;
use src\Domain\Entity\Token;
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
}
