<?php
namespace src\Presenter\Modal;

use src\Constant\Constant as C;
use src\Constant\Template;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\ClasseReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Reader\SpellSchoolReader;
use src\Utils\Html;

class SpellFilterModalPresenter implements ModalPresenter
{
    public function __construct(
        private ReferenceReader $referenceReader,
        private SpellSchoolReader $spellSchoolReader,
        private ClasseReader $classeReader,
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
        $this->dealWithClasses($classOptions, $nbClassOptions);

        // Liste des écoles
        $schoolOptions = '';
        $nbSchoolOptions = 0;
        $strAllSchoolSelected = ' '.C::CHECKED;
        $this->dealWithSchools($schoolOptions, $nbSchoolOptions);

        // Liste des sources
        $sourceOptions = '';
        $nbSourceOptions = 0;
        $strAllSourceSelected = ' '.C::CHECKED;
        $this->dealWithSources($sourceOptions, $nbSourceOptions);

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

    private function dealWithClasses(string &$classOptions, int &$nbClassOptions): void
    {
        $classes = $this->classeReader->allSpellCastingClasses();
        // Liste des classes
        $defaultClassSelection = array_map(fn($case) => $case->id, $classes->toArray());
        $selectedClasses = $defaultClassSelection;
        foreach ($classes as $classe) {
            $value = $classe->id;
            if (in_array($value, $selectedClasses)) {
                ++$nbClassOptions;
                $classOptions .= Html::getOption(ucfirst($classe->name), [C::VALUE=>$value], true);
            } else {
                $classOptions .= Html::getOption(ucfirst($classe->name), [C::VALUE=>$value]);
            }
        }
    }

    private function dealWithSchools(string &$schoolOptions, int &$nbSchoolOptions): void
    {
        $spellSchools = $this->spellSchoolReader->allSpellSchools();
        $defaultSchoolSelection = array_map(fn($case) => $case->id, $spellSchools->toArray());
        $selectedSchools = $defaultSchoolSelection;
        foreach ($spellSchools as $spellSchool) {
            $value = $spellSchool->id;
            if (in_array($value, $selectedSchools)) {
                ++$nbSchoolOptions;
                $schoolOptions .= Html::getOption($spellSchool->name, [C::VALUE=>$value], true);
            } else {
                $schoolOptions .= Html::getOption($spellSchool->name, [C::VALUE=>$value]);
            }
        }
    }

    private function dealWithSources(string &$sourceOptions, int &$nbSourceOptions): void
    {
        $sources = $this->referenceReader->allReferences();
        $defaultSourceSelection = array_map(fn($case) => $case->id, $sources->toArray());
        $selectedSources = $defaultSourceSelection;
        foreach ($sources as $source) {
            $value = $source->id;
            if (in_array($value, $selectedSources)) {
                ++$nbSourceOptions;
                $sourceOptions .= Html::getOption($source->name, [C::VALUE=>$value], true);
            } else {
                $sourceOptions .= Html::getOption($source->name, [C::VALUE=>$value]);
            }
        }
    }
}
