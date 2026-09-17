<?php
namespace src\Presenter\Modal;

use src\Constant\Constant as C;
use src\Constant\Template;
use src\Enum\ClassEnum;
use src\Enum\MagicSchoolEnum;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\ReferenceReader;
use src\Utils\Html;

class SpellFilterModalPresenter implements ModalPresenter
{
    public function __construct(
        private ReferenceReader $referenceReader,
        private TemplateRenderer $renderer,
    ) {}

    public function render(): string
    {
        // Liste des niveaux
        $minOptions = '';
        $maxOptions = '';
        $selectedMin = 0;
        $selectedMax = 9;
        for ($i=0; $i<=9; $i++) {
            $minOptions .= Html::getOption($i, [C::VALUE=>$i], $selectedMin==$i);
            $maxOptions .= Html::getOption($i, [C::VALUE=>$i], $selectedMax==$i);
        }

        // Liste des classes
        $classOptions = '';
        $nbClassOptions = 0;
        $strAllClassSelected = ' '.C::CHECKED;
        $defaultClassSelection = array_map(fn($case) => $case->value, array_filter(ClassEnum::cases(), fn($case) => !in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])));
        $selectedClasses = $defaultClassSelection;
        foreach (ClassEnum::cases() as $case) {
            if (in_array($case, [ClassEnum::Bab, ClassEnum::Gue, ClassEnum::Moi, ClassEnum::Rou])) {
                continue;
            }
            $value = $case->value;
            if (in_array($value, $selectedClasses)) {
                ++$nbClassOptions;
                $classOptions .= Html::getOption(ucfirst($case->label()), [C::VALUE=>$value], true);
            } else {
                $classOptions .= Html::getOption(ucfirst($case->label()), [C::VALUE=>$value]);
            }
        }

        // Liste des écoles
        $schoolOptions = '';
        $nbSchoolOptions = 0;
        $strAllSchoolSelected = ' '.C::CHECKED;
        $defaultSchoolSelection = array_map(fn($case) => $case->value, MagicSchoolEnum::cases());
        $selectedSchools = $defaultSchoolSelection;
        foreach (MagicSchoolEnum::cases() as $case) {
            $value = $case->value;
            if (in_array($value, $selectedSchools)) {
                ++$nbSchoolOptions;
                $schoolOptions .= Html::getOption(ucfirst($case->label()), [C::VALUE=>$value], true);
            } else {
                $schoolOptions .= Html::getOption(ucfirst($case->label()), [C::VALUE=>$value]);
            }
        }

        // Liste des sources
        $sourceOptions = '';
        $nbSourceOptions = 0;
        $strAllSourceSelected = ' '.C::CHECKED;
        $sources = $this->referenceReader->allReferences();
        $defaultSourceSelection = array_map(fn($case) => $case->code, $sources->toArray());
        $selectedSources = $defaultSourceSelection;
        foreach ($sources as $source) {
            $value = $source->code;
            if (in_array($value, $selectedSources)) {
                ++$nbSourceOptions;
                $sourceOptions .= Html::getOption($source->name, [C::VALUE=>$value], true);
            } else {
                $sourceOptions .= Html::getOption($source->name, [C::VALUE=>$value]);
            }
        }

        // Rituels
        $onlyRituels = false;
        $strRituels = $onlyRituels ? ' '.C::CHECKED : '';

        // Concentration
        $onlyConcentrate = false;
        $strConcentration = $onlyConcentrate ? ' '.C::CHECKED : '';

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
            // Sources
            $strAllSourceSelected,
            $nbSourceOptions,
            $sourceOptions,
        ];

        $modalContent = $this->renderer->render(
            Template::SPELL_FILTER_MODAL,
            $attrContent
        );

        $attributes = [
            C::SPELL_FILTER,
            'Sorts - Filtres',
            $modalContent,
            'Filtrer'
        ];

        return $this->renderer->render(
            Template::MAIN_MODAL,
            $attributes
        );
    }
}
