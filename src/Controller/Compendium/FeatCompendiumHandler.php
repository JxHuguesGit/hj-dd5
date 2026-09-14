<?php
namespace src\Controller\Compendium;

use src\Collection\Collection;
use src\Constant\Field as F;
use src\Constant\Language as L;
use src\Domain\Criteria\AbilityCriteria;
use src\Domain\Entity\Feat;
use src\Domain\Entity\FeatAbility;
use src\Enum\AbilityEnum;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\FeatFormBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\FeatPrerequisiteService;
use src\Service\Domain\FeatPrerequisService;
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
use src\Service\Reader\PreRequisReader;
use src\Service\Reader\ReferenceReader;
use src\Service\Writer\FeatAbilityWriter;
use src\Service\Writer\FeatWriter;
use src\Utils\Session;

class FeatCompendiumHandler extends AbstractCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private FeatWriter $featWriter,
        private FeatAbilityWriter $featAbilityWriter,
        private FeatReader $featReader,
        private FeatTypeReader $featTypeReader,
        private OriginReader $originReader,
        private FeatAbilityReader $featAbilityReader,
        private AbilityReader $abilityReader,
        private ReferenceReader $referenceReader,
        private FeatPrerequisService $featPrerequisiteService,
        private PreRequisReader $preRequisReader,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    protected function handleEditSubmit(int $slug): string
    {
        $feat = $this->featReader->featById($slug);
        if (! $feat) {
            $this->toastContent = $this->toastBuilder->error("Le don modifié n'existe pas.");
            return $this->renderList();
        }

        $changedFields = [];
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field    = $value;
                $changedFields[] = $field;
            }
        }

        /*
        On doit vérifier si on a au moins une caractéristique cochée.
        Si on est général ou Faveur épique, au moins une doit être cochée.
        
replaceFeatAbilities


        if (! $hasAbilityLinked) {
            $this->controlNoAbilityLinked($currentAbilities, $changedFields, $feat);
            return $this->renderEdit($slug);
        } else {
            // On sauvegarde les liens
            $this->featAbilityWriter->deleteFeatAbilities($currentAbilities);
            // On créé les nouveaux liens
            $featAbility = new FeatAbility([F::FEATID => $feat->id]);
            $criteria    = new AbilityCriteria();
            foreach ($selectedAbilities as $abilityEnum) {
                $criteria->name         = $abilityEnum->label();
                $ability                = $this->abilityReader->allAbilities($criteria)?->first();
                $featAbility->abilityId = $ability->id;
                $this->featAbilityWriter->insert($featAbility);
            }
        }
        */

        if (! empty($changedFields)) {
            // On sauvegarde le changement
            $this->featWriter->updatePartial($feat, $changedFields);
        }
        $this->toastContent .= $this->toastBuilder->success("Le don <strong>" . $feat->name . "</strong> a été correctement mis à jour.");
        return $this->renderList();
    }

    private function controlNoAbilityLinked(
        Collection $currentAbilities,
        array $changedFields,
        Feat $feat
    ): void
    {
        if (Session::fromPost(F::FEATTYPEID) == 2 && $currentAbilities->isEmpty()) {
            $this->toastContent = $this->toastBuilder->info("Pour les dons généraux, au moins une caractéristique doit être sélectionnée.");
        } elseif (empty($changedFields)) {
            $this->toastContent = $this->toastBuilder->info(L::NO_MODIFICATION_ENTRY);
        } else {
            $this->toastContent = $this->toastBuilder->success("Le don <strong>" . $feat->name . "</strong> a été correctement mis à jour.");
        }
    }

    private function handleFeatAbilities(
        array &$selectedAbilities,
        Collection &$currentAbilities,
        int $featId
    )
    {
        foreach (AbilityEnum::cases() as $ability) {
            $val = Session::fromPost($ability->value);
            if ($val) {
                $case                = AbilityEnum::tryFrom($ability->value);
                $selectedAbilities[] = $case;
            }

        }
        if (empty($selectedAbilities)) {
            return false;
        }

        $currentAbilities = $this->featAbilityReader->featAbilitiesByFeatId($featId);
        $currentValues    = [];
        foreach ($currentAbilities as $fa) {
            $ability = $this->abilityReader->abilityById($fa->abilityId);
            $enum    = AbilityEnum::fromLabel($ability->name);
            if ($enum) {
                $currentValues[] = $enum->value;
            }
        }
        $newValues        = array_map(fn($a) => $a->value, $selectedAbilities);
        return $currentValues !== $newValues;
    }

    protected function renderEdit(int $slug): string
    {
        $feat = $this->featReader->featById($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new FeatFormBuilder(
                new WpPostService(),
                $this->featTypeReader,
                $this->abilityReader,
                $this->featAbilityReader,
                $this->referenceReader,
                $this->preRequisReader
            ),
            $this->toastContent
        );

        return $page->renderAdmin('', $feat);
    }

    protected function renderList(): string
    {
        $feats     = $this->featReader->allFeatsWithRelations();
        $presenter = new FeatListPresenter(
            $this->originReader,
            $this->featPrerequisiteService,
            $this->featTypeReader,
            $this->referenceReader,
            $this->featAbilityReader,
            $this->abilityReader
        );
        $presentContent = $presenter->present($feats);
        $page           = new PageList(
            $this->templateRenderer,
            new FeatTableBuilder(true)
        );
        return $page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
