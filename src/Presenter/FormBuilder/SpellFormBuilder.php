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
use src\Service\Reader\ClasseReader;
use src\Service\Reader\ReferenceReader;
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
        private WpPostService $wpPostService,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Spell) {
            throw new \InvalidArgumentException('Expected Spell');
        }

        $entityWpPostId      = $entity->wpPostId ?? -1;
        $params[C::TITLE]    = $entityWpPostId == -1 ? 'Nouveau Sort' : 'Sort : ' . $entity->name;
        $params[C::TYPE]     = $entityWpPostId == -1 ? C::NEW : C::EDIT;
        $params['cancelUrl'] = UrlGenerator::admin(C::ONG_COMPENDIUM, C::SPELLS);
        $form                = $this->createForm($params);

        $selectSchools = $this->buildSpellSchools();
        $selectLevels  = $this->buildLevels();
        $selectSources = $this->buildSources();
        $selectWordpress = $this->buildWordpress($entityWpPostId);
        $spellClassesSel = $this->buildClasses();
        $vsCheckBoxes = $this->buildVSCheckboxes();

        $mockArray = [];

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
            ;
        $params = [
            C::CSSCLASS => [C::CSSCLASS => 'col-md-8 row mx-0'],
            'hasLegend' => false,
        ];
        $fieldsetInterne = new FieldsetField('', false, $params);
        $fieldsetInterne
            ->addField(new SelectField(
                F::CASTINGTIMEID, "Temps d'incantation", $entity->castingTimeId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::RANGEID, "Portée", $entity->rangeId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_6]
            ))
            ->addField(new SelectField(
                F::DURATIONID, "Durée", $entity->durationId, $mockArray,
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
        $fieldset
            ->addField($fieldsetInterne);
        if ($entityWpPostId == -1) {
            $fieldset
                ->addField(new SelectField(
                    F::WPPOSTID, 'Nom du sort', $entity->wpPostId, $selectWordpress,
                    [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
                ));
        } else {
            $fieldset
                ->addField(new TextField(
                    F::WPPOSTID, 'Nom du sort', $entity->name, true,
                    [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
                ));
        }
        $fieldset
            ->addField(new SelectField(
                F::MATERIALCOMPID, "Composante matérielle", $entity->materialComponentId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_8]
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
                [C::OUTERDIVCLASS => B::COL_MD_6 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::SPELLTRIGGERID, "Déclenchement", $entity->spellTriggerId, $mockArray,
                [C::OUTERDIVCLASS => B::COL_MD_6]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }

    private function buildVSCheckboxes(): Collection
    {
        $collection = new Collection();
        $collection
            ->add(new CheckboxField('vs', 'V', 'v', false, [C::OUTERDIVCLASS => '']))
            ->add(new CheckboxField('vs', 'S', 's', false, [C::OUTERDIVCLASS => '']))
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
        return array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $sources->toArray()
        );
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
        return array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $schools->toArray()
        );
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

        $options = [];
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
