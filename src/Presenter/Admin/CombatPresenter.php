<?php
namespace src\Presenter\Admin;

use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Domain\Entity\Combat;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;


final class CombatPresenter
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function presentHeader(Combat $combat): string
    {
        if ($combat === null || !$combat->active) {
            return Html::getButton(
                Html::getIcon(I::SWORDS) . ' Débuter le combat',
                [
                    C::CSSCLASS => 'btn btn--combat-start btn--full',
                ]
            );
        }

        return '<div class="turn-controls">
                <button class="btn btn--nav" disabled=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg> Prev</button>
                <div class="turn-info">
                    <div class="turn-info__round">Round <span>1</span></div>
                    <div class="turn-info__name">Charly</div>
                </div>
                <button class="btn btn--nav" title="Spacebar">Next <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg><kbd class="kbd-hint">Space</kbd></button>
            </div>
            <button class="btn btn--danger btn--full" style="margin-top: 8px;">End Combat</button>';
    }
}
