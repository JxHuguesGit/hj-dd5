<?php
namespace src\Presenter\FormBuilder;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Language as L;
use src\Domain\Criteria\AbilityCriteria;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\Feat;
use src\Enum\AbilityEnum;
use src\Presenter\ViewModel\FeatAbilityView;
use src\Service\Domain\FeatPreRequisService;
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class SpellFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private WpPostService $wpPostService,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Feat) {
            throw new \InvalidArgumentException('Expected DomainFeat');
        }

        $entityWpPostId = $entity->wpPostId ?? -1;
        $this->wpPostService->getById($entityWpPostId);

        $params[C::TITLE] = $entityWpPostId == -1 ? 'Nouveau Sort' : 'Sort : ' . $entity->name;
        $params[C::TYPE]  = $entityWpPostId == -1 ? C::NEW : C::EDIT;
        $params['cancelUrl']         = UrlGenerator::admin(C::ONG_COMPENDIUM, C::SPELLS);
        $form                        = $this->createForm($params);

        $selectSchools = [];
        $selectLevels  = [];
        $selectSources = [];
        $spellClassesSel = new Collection();
        $selectMaterialComps = [];

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
            ->addField(new CheckboxGroupField(
                F::SPELLCLASSES . '[]',
                $spellClassesSel,
                [C::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3]
            ))
            ->addField(new CheckboxGroupField(
                F::COMPONENTS,
                new Collection(['V', 'S', 'M']),
                [C::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                F::MATERIALCOMPID, L::MATERIALCOMP, $entity->materialComponentId, $selectMaterialComps,
                [C::OUTERDIVCLASS => B::COL_MD_8]
            ))
            ->addField(new NumberField(
                F::WPPOSTID, 'Post ID', $entity->wpPostId, false,
                [C::OUTERDIVCLASS => B::COL_MD_2 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                F::NAME, C::NAME, $entityWpPostId == -1 ? '' : $entity->name, true,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new TextField(
                F::SLUG, C::SLUG, $entityWpPostId == -1 ? '' : $entity->slug, true,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new FillerField())
            ->addField(new TextareaField(
                F::DESCRIPTION, L::DESCRIPTION, $this->wpPostService->getPostContent(), true,
                [
                    C::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3,
                    C::STYLE         => 'height: 100px',
                ]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }

}
