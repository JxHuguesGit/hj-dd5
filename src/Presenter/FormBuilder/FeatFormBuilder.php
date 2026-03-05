<?php
namespace src\Presenter\FormBuilder;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Domain\Criteria\FeatAbilityCriteria;
use src\Domain\Entity\Feat;
use src\Enum\AbilityEnum;
use src\Presenter\ViewModel\FeatAbilityView;
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatTypeReader;
use src\Utils\Form;
use src\Utils\UrlGenerator;

class FeatFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private WpPostService $wpPostService,
        private FeatTypeReader $featTypeReader,
        private AbilityReader $abilityReader,
        private FeatAbilityReader $featAbilityReader,
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        if (! $entity instanceof Feat) {
            throw new \InvalidArgumentException('Expected DomainFeat');
        }

        $featTypes      = $this->featTypeReader->allFeatTypes();
        $selectElements = array_map(
            fn($t) => [
                Constant::CST_VALUE => $t->id,
                Constant::CST_LABEL => $t->name,
            ],
            $featTypes->toArray()
        );
        $this->wpPostService->getById($entity->postId);

        $params[Constant::CST_TITLE] = 'Don : ' . $entity->name;
        $params[Constant::CST_TYPE]  = Constant::EDIT;
        $params['cancelUrl']         = UrlGenerator::admin(Constant::ONG_COMPENDIUM, Constant::FEATS);
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
                Field::ID, 'ID', $entity->id, true,
                [Constant::OUTERDIVCLASS => B::COL_MD_3 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                Field::NAME, Constant::CST_NAME, $entity->name, true,
                [Constant::OUTERDIVCLASS => B::COL_MD_5]
            ))
            ->addField(new FillerField(
                '', '', '', '',
                [Constant::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new NumberField(
                Field::POSTID, 'Post ID', $entity->postId, false,
                [Constant::OUTERDIVCLASS => B::COL_MD_4 . ' ' . B::MB3]
            ))
            ->addField(new TextField(
                Field::SLUG, Constant::CST_SLUG, $entity->slug, true,
                [Constant::OUTERDIVCLASS => B::COL_MD_8,
                ]))
            ->addField(new TextareaField(
                Field::DESCRIPTION, Language::LG_DESCRIPTION, $this->wpPostService->getPostContent(), true,
                [
                    Constant::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3,
                    'style'                 => 'height: 200px',
                ]
            ))
            ->addField(new TextField(
                Constant::CST_PREREQUIS,
                Language::LG_PREQUISITE,
                $this->wpPostService->getField(Constant::CST_PREREQUIS),
                true,
                [Constant::OUTERDIVCLASS => B::COL_MD_12 . ' ' . B::MB3]
            ))
            ->addField(new SelectField(
                Field::FEATTYPEID, Language::LG_FEAT_TYPE, $entity->featTypeId, $selectElements,
                [Constant::OUTERDIVCLASS => B::COL_MD_4]
            ))
            ->addField(new CheckboxGroupField(
                'ability',
                $featAbilitiesSel,
                [
                    Constant::OUTERDIVCLASS => B::COL_MD_8,
                    'extraClass'            => $entity->featTypeId != 2 ? B::DNONE : '',
                ]
            ))
        ;
        $form->addField($fieldset);
        return $form;
    }

}
