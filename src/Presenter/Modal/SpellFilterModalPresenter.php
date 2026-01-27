<?php
namespace src\Presenter\Modal;

use src\Constant\Template;
use src\Controller\Utilities;

class SpellFilterModalPresenter implements ModalPresenter
{
    public function __construct(
        private Utilities $utilities,
    ) {}

    public function render(): string
    {
        // Liste des niveaux
        $minOptions = '';
        $maxOptions = '';
        for ($i=0; $i<=9; $i++) {
            $minOptions .= '<option value="'.$i.'">'.$i.'</option>';
            $maxOptions .= '<option value="'.$i.'">'.$i.'</option>';
        }

        $attrContent = [
            $minOptions,
            $maxOptions,
        ];

        $modalContent = $this->utilities->getRender(
            Template::SPELL_FILTER_MODAL,
            $attrContent
        );

        $attributes = [
            'spellFilter',
            'Sorts - Filtres',
            $modalContent,
            'Filtrer'
        ];

        return $this->utilities->getRender(
            Template::MAIN_MODAL,
            $attributes
        );
    }
}