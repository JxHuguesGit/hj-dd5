<?php
namespace src\Presenter\Modal;

use src\Constant\Constant;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Enum\ClassEnum;
use src\Enum\MagicSchoolEnum;
use src\Utils\Html;

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
        $selectedMin = 0;
        $selectedMax = 9;
        for ($i=0; $i<=9; $i++) {
            $minOptions .= Html::getOption($i, [Constant::CST_VALUE=>$i], $selectedMin==$i);
            $maxOptions .= Html::getOption($i, [Constant::CST_VALUE=>$i], $selectedMax==$i);
        }

        // Liste des classes
        $classOptions = '';
        $nbClassOptions = 0;
        $strAllClassSelected = ' '.Constant::CST_CHECKED;
        $defaultClassSelection = array_map(fn($case) => $case->value, array_filter(ClassEnum::cases(), fn($case) => !in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])));
        $selectedClasses = $defaultClassSelection;
        foreach (ClassEnum::cases() as $case) {
            if (in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])) {
                continue;
            }
            $value = $case->value;
            if (in_array($value, $selectedClasses)) {
                ++$nbClassOptions;
                $classOptions .= Html::getOption(ucfirst($case->label()), [Constant::CST_VALUE=>$value], true);
            } else {
                $classOptions .= Html::getOption(ucfirst($case->label()), [Constant::CST_VALUE=>$value]);
            }
        }

        // Liste des écoles
        $schoolOptions = '';
        $nbSchoolOptions = 0;
        $strAllSchoolSelected = ' '.Constant::CST_CHECKED;
        $defaultSchoolSelection = array_map(fn($case) => $case->value, MagicSchoolEnum::cases());
        $selectedSchools = $defaultSchoolSelection;
        foreach (MagicSchoolEnum::cases() as $case) {
            $value = $case->value;
            if (in_array($value, $selectedSchools)) {
                ++$nbSchoolOptions;
                $schoolOptions .= Html::getOption(ucfirst($case->label()), [Constant::CST_VALUE=>$value], true);
            } else {
                $schoolOptions .= Html::getOption(ucfirst($case->label()), [Constant::CST_VALUE=>$value]);
            }
        }

        // Rituels
        $onlyRituels = false;
        $strRituels = $onlyRituels ? ' '.Constant::CST_CHECKED : '';

        // Concentration
        $onlyConcentrate = false;
        $strConcentration = $onlyConcentrate ? ' '.Constant::CST_CHECKED : '';

        $attrContent = [
            // Niveau
            $minOptions,
            $maxOptions,
            // Classes
            $strAllClassSelected,
            $nbClassOptions,
            $classOptions,
            // Ecoles
            $strAllSchoolSelected,
            $nbSchoolOptions,
            $schoolOptions,
            // Rituel,
            $strRituels,
            // Concentration
            $strConcentration,
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