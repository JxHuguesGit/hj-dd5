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
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class FeatFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private WpPostService $wpPostService,
        private FeatTypeReader $featTypeReader,
        private AbilityReader $abilityReader,
        private FeatAbilityReader $featAbilityReader,
        private ReferenceReader $referenceReader,
        private PreRequisReader $preRequisReader
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Feat) {
            throw new \InvalidArgumentException('Expected DomainFeat');
        }

        $featTypes      = $this->featTypeReader->allFeatTypes();
        $selectElements = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $featTypes->toArray()
        );
        $entityWpPostId = $entity->wpPostId ?? -1;
        $this->wpPostService->getById($entityWpPostId);

        $preRequis       = $this->preRequisReader->allPreRequis();
        $selectPreRequis = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $preRequis->toArray()
        );
        array_unshift($selectPreRequis, [C::VALUE => 0, C::LABEL => 'Aucun']);

        $sources       = $this->referenceReader->allReferences();
        $selectSources = array_map(
            fn($t) => [
                C::VALUE => $t->id,
                C::LABEL => $t->name,
            ],
            $sources->toArray()
        );

        $params[C::TITLE] = $entityWpPostId == -1 ? 'Nouveau Don' : 'Don : ' . $entity->name;
        $params[C::TYPE]  = $entityWpPostId == -1 ? C::NEW : C::EDIT;
        $params['cancelUrl']         = UrlGenerator::admin(C::ONG_COMPENDIUM, C::FEATS);
        $form                        = $this->createForm($params);

        $featAbilitiesSel = new Collection();
        $abilities        = $this->abilityReader->allAbilities();
        $criteria         = new FeatAbilityCriteria();
        $criteria->featId = $entity->id;
        foreach ($abilities as $ability) {
            $criteria->abilityId = $ability->id;
            $featAbilities       = $this->featAbilityReader->allFeatAbilities($criteria);
            $featAbilitiesSel->add(new FeatAbilityView(
                $ability->id, AbilityEnum::fromLabel($ability->name), $ability->name, ! $featAbilities->isEmpty()
            ));
        }

        $fieldset = new FieldsetField('');
        $fieldset
            ->addField(new NumberField(
                F::ID, 'ID', $entity->id, true,
                [C::OUTERDIVCLASS => B::COL_MD_2]
            ))
            ->addField(new SelectField(
                F::FEATTYPEID, L::FEAT_TYPE, $entity->featTypeId, $selectElements,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new SelectField(
                F::SOURCEID, L::SOURCE, $entity->sourceId, $selectSources,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new FillerField())
            ->addField(new SelectField(
                F::PREREQUISID, L::PREQUISITE, $entity->preRequisId, $selectPreRequis,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new CheckboxGroupField(
                'ability',
                $featAbilitiesSel,
                [
                    C::OUTERDIVCLASS => B::COL_MD_8,
                ]
            ))
            ->addField(new FillerField())
            ->addField(new NumberField(
                F::WPPOSTID, 'Post ID', $entity->wpPostId, false,
                [C::OUTERDIVCLASS => B::COL_MD_2]
            ))
            ->addField(new TextField(
                F::NAME, C::NAME, $entityWpPostId == -1 ? '' : $entity->name, true,
                [C::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new TextField(
                F::SLUG, C::SLUG, $entityWpPostId == -1 ? '' : $entity->slug, true,
                [C::OUTERDIVCLASS => B::COL_MD_4,
                ]))
            ->addField(new FillerField())
            ->addField(new TextareaField(
                F::DESCRIPTION, L::DESCRIPTION, $this->wpPostService->getPostContent(), true,
                [
                    C::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3,
                    'style'                 => 'height: 100px',
                ]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }

}
