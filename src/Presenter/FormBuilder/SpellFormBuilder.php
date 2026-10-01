<?php
namespace src\Presenter\FormBuilder;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Language as L;
use src\Domain\Entity\Spell;
use src\Presenter\ViewModel\ClasseView;
use src\Service\Domain\WpPostService;
use src\Service\Reader\SpellCastingTimeReader;
use src\Service\Reader\ClasseReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Reader\SpellComponentReader;
use src\Service\Reader\SpellDurationReader;
use src\Service\Reader\SpellRangeReader;
use src\Service\Reader\SpellReader;
use src\Service\Reader\SpellSchoolReader;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class SpellFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private SpellReader $spellReader,
        private SpellSchoolReader $spellSchoolReader,
        private ClasseReader $classeReader,
        private ReferenceReader $referenceReader,
        private SpellCastingTimeReader $castingTimeReader,
        private SpellRangeReader $spellRangeReader,
        private SpellDurationReader $spellDurationReader,
        private SpellComponentReader $spellComponentReader,
        private WpPostService $wpPostService,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Spell) {
            throw new \InvalidArgumentException('Expected Spell');
        }

        $entityWpPostId      = $entity->wpPostId ?? -1;
        $newEntity = ($entityWpPostId == -1 || $entityWpPostId == 0);
        $this->wpPostService->getById($entityWpPostId);
        $params[C::TITLE]    = $newEntity ? 'Nouveau Sort' : 'Sort : ' . $entity->name;
        $params[C::TYPE]     = $newEntity ? C::NEW : C::EDIT;
        $params['cancelUrl'] = UrlGenerator::admin(C::ONG_COMPENDIUM, C::SPELLS);
        $form                = $this->createForm($params);
        $entityName          = $newEntity ? '' : $entity->name;

        $selectSchools = $this->buildSpellSchools();
        $selectLevels  = $this->buildLevels();
        $selectSources = $this->buildSources();
        $selectWordpress = $this->buildWordpress($entityWpPostId);
        $spellClassesSel = $this->buildClasses();
        $vsCheckBoxes = $this->buildVSCheckboxes($entity);
        $castingTimes = $this->buildCastingTimes();
        $spellRanges = $this->buildRanges();
        $spellDurations = $this->buildDurations();
        $spellComponents = $this->buildComponents();

        $mockArray = [[C::VALUE => 0, C::LABEL => '']];

        ///////////////////////////
        // Fieldset Interne (TI, Portée, Durée,)
        $paramsFieldsetInterne = [
            C::CSSCLASS => [C::CSSCLASS => 'col-md-8 row mx-0'],
            'hasLegend' => false,
        ];
        $fieldsetInterne = new FieldsetField('', false, $paramsFieldsetInterne);
        $fieldsetInterne
            ->addField(new SelectField(
                F::CASTINGTIMEID, "Temps d'incantation", $entity->castingTimeId, $castingTimes,
                [C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::RANGEID, L::RANGE, $entity->rangeId, $spellRanges,
                [C::OUTERDIVCLASS => B::COL_MD_6]
            ))
            ->addField(new SelectField(
                F::DURATIONID, L::DURATION, $entity->durationId, $spellDurations,
                [C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3]
            ))
            ->addField(new CheckboxGroupField(
                F::COMPONENTS,
                $vsCheckBoxes,
                [
                    C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3,
                    C::CSSCLASS      => B::COL_MD_6
                ]
            ))
        ;

        //////////////////////////
        // FieldForm Nom du sort
        if ($newEntity) {
            $fieldSpellName = new SelectField(
                F::WPPOSTID, 'Nom du sort', $entity->wpPostId, $selectWordpress,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            );
        } else {
            $fieldSpellName = new TextField(
                F::WPPOSTID, 'Nom du sort', $entityName, true,
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            );
        }

        //////////////////////////
        // Fieldset principal
        $fieldset = new FieldsetField('');
        $fieldset
            ->addField(new NumberField(
                F::ID, 'ID', $entity->id, true,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::SCHOOLID, L::SCHOOL, $entity->schoolId, $selectSchools,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new SelectField(
                F::LEVEL, L::LEVEL, $entity->level, $selectLevels,
                [C::OUTERDIVCLASS => B::COL_MD_2]
            ))
            ->addField(new SelectField(
                F::SOURCEID, L::SOURCE, $entity->sourceId, $selectSources,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new SelectField(
                F::SPELLCLASSES . '[]', L::CLASSES, [], $spellClassesSel,
                [
                    C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3,
                    'multiple'  => true,
                    'rows'      => 5,
                ]
            ))
            ->addField($fieldsetInterne)
            ->addField($fieldSpellName)
            ->addField(new EmptyField([C::CSSCLASS => B::COL_MD_3]))
            ->addField(new SelectField(
                F::MATERIALCOMPID, L::MATERIALCOMP, $entity->materialComponentId, $spellComponents,
                [C::OUTERDIVCLASS => B::COL_MD_5]
            ))
            ->addField(new TextareaField(
                F::DESCRIPTION, L::DESCRIPTION, $this->wpPostService->getPostContent(), true,
                [
                    C::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3,
                    C::STYLE         => 'height: 100px',
                ]
            ))
            ->addField(new SelectField(
                F::SPELLENHANCEMENTID, "Amélioration", $entity->spellEnhancementId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_5 . ' ' . B::MB3]
            ))
            ->addField(new EmptyField([C::CSSCLASS => B::COL_MD_2]))
            ->addField(new SelectField(
                F::SPELLTRIGGERID, "Déclenchement", $entity->spellTriggerId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_5]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }

    private function buildComponents(): array
    {
        $components = $this->spellComponentReader->allSpellComponents();
        $buildArray = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->description,
            ],
            $components->toArray()
        );
        array_unshift($buildArray, [C::VALUE => 0, C::LABEL => '']);
        return $buildArray;
    }
    private function buildDurations(): array
    {
        $builds = $this->spellDurationReader->allSpellDurations();
        $buildArray = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $builds->toArray()
        );
        array_unshift($buildArray, [C::VALUE => 0, C::LABEL => '']);
        return $buildArray;
    }
    private function buildRanges(): array
    {
        $ranges = $this->spellRangeReader->allSpellRanges();
        $rangeArray = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $ranges->toArray()
        );
        array_unshift($rangeArray, [C::VALUE => 0, C::LABEL => '']);
        return $rangeArray;
    }
    private function buildCastingTimes(): array
    {
        $castingTimes = $this->castingTimeReader->allSpellCastingTimes();
        $castingTimeArray = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $castingTimes->toArray()
        );
        array_unshift($castingTimeArray, [C::VALUE => 0, C::LABEL => '']);
        return $castingTimeArray;
    }
    private function buildVSCheckboxes(Spell $spell): Collection
    {
        $components = $spell->components ?? '';
        
        $vParams = [C::OUTERDIVCLASS => ''];
        if (strpos($components, 'V')!==false) {
            $vParams[C::CHECKED] = true;
        }
        $sParams = [C::OUTERDIVCLASS => ''];
        if (strpos($components, 'S')!==false) {
            $sParams[C::CHECKED] = true;
        }
        $collection = new Collection();
        $collection
            ->add(new CheckboxField('vs[]', 'V', 'v', false, $vParams))
            ->add(new CheckboxField('vs[]', 'S', 's', false, $sParams))
        ;
        return $collection;
    }
    private function buildClasses(): array
    {
        $classes = $this->classeReader->allSpellCastingClasses();
        return array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $classes->toArray()
        );
    }
    private function buildSources(): array
    {
        $sources       = $this->referenceReader->allReferences();
        $sourceArray = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $sources->toArray()
        );
        array_unshift($sourceArray, [C::VALUE => 0, C::LABEL => '']);
        return $sourceArray;
    }
    private function buildLevels(): array
    {
        $selectLevels  = [];
        for ($i=0; $i<=9; $i++) {
            $selectLevels[] = [
                C::VALUE => $i,
                C::LABEL => $i,
            ];
        }
        return $selectLevels;
    }
    private function buildSpellSchools(): array
    {
        $schools       = $this->spellSchoolReader->allSpellSchools();
        $schoolArray   = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $schools->toArray()
        );
        array_unshift($schoolArray, [C::VALUE => 0, C::LABEL => '']);
        return $schoolArray;
    }
    private function buildWordpress(int $wpPostId): array
    {
        $spells = $this->spellReader->allSpells();
        $existingWpPostIds = [];
        foreach ($spells as $spell) {
            $existingWpPostIds[] = $spell->wpPostId;
        }

        $posts = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'category_name'  => 'sort',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);

        $options = [[C::VALUE => 0, C::LABEL => '']];
        foreach ($posts as $post) {
            if (in_array($post->ID, $existingWpPostIds, true) && $wpPostId == -1) {
                continue;
            }
            $options[] = [
                'value' => $post->ID,
                'label' => $post->post_title,
            ];
        }
        return $options;
    }

}
