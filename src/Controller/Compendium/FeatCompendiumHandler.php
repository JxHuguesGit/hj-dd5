<?php
namespace src\Controller\Compendium;

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
use src\Service\Domain\WpPostService;
use src\Service\Reader\AbilityReader;
use src\Service\Reader\FeatAbilityReader;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;
use src\Service\Reader\OriginReader;
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
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    protected function handleEditSubmit(string $slug): string
    {
        $feat = $this->featReader->featBySlug($slug);
        if (! $feat) {
            $this->toastContent = $this->toastBuilder->error("Le don modifié n'existe pas.");
            return $this->renderList($slug);
        }
        $hasAbilityLinked = false;

        if (Session::fromPost(F::FEATTYPEID) == 2) {
            $selectedAbilities = [];
            foreach (AbilityEnum::cases() as $ability) {
                $val = Session::fromPost($ability->value);
                if ($val) {
                    $case                = AbilityEnum::tryFrom($ability->value);
                    $selectedAbilities[] = $case;
                }

            }
            if (empty($selectedAbilities)) {
                $this->toastContent = $this->toastBuilder->info("Pour les dons généraux, au moins une caractéristique doit être sélectionnée.");
                return $this->renderEdit($slug);
            }

            $currentAbilities = $this->featAbilityReader->featAbilitiesByFeatId($feat->id);
            $currentValues    = [];
            foreach ($currentAbilities as $fa) {
                $ability = $this->abilityReader->abilityById($fa->abilityId);
                $enum    = AbilityEnum::fromLabel($ability->name);
                if ($enum) {
                    $currentValues[] = $enum->value;
                }
            }
            $newValues        = array_map(fn($a) => $a->value, $selectedAbilities);
            $hasAbilityLinked = $currentValues !== $newValues;
        }

        $changedFields = [];
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field    = $value;
                $changedFields[] = $field;
            }
        }

        if (empty($changedFields) && ! $hasAbilityLinked) {
            $this->toastContent = $this->toastBuilder->info(L::NO_MODIFICATION_ENTRY);
            return $this->renderEdit($slug);
        }

        if ($hasAbilityLinked) {
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
        if (! empty($changedFields)) {
            // On sauvegarde le changement
            $this->featWriter->updatePartial($feat, $changedFields);
        }
        $this->toastContent = $this->toastBuilder->success("Le don <strong>" . $feat->name . "</strong> a été correctement mis à jour.");
        return $this->renderList($slug);
    }

    protected function renderEdit(string $slug): string
    {
        $feat = $this->featReader->featBySlug($slug);

        $page = new PageForm(
            $this->templateRenderer,
            new FeatFormBuilder(
                new WpPostService(),
                $this->featTypeReader,
                $this->abilityReader,
                $this->featAbilityReader
            ),
            $this->toastContent
        );

        return $page->renderAdmin('', $feat);
    }

    protected function renderList(): string
    {
        $feats     = $this->featReader->allFeats();
        $presenter = new FeatListPresenter(
            $this->originReader,
            $this->featAbilityReader,
            $this->abilityReader,
            new WpPostService()
        );
        $presentContent = $presenter->present($feats);
        $page           = new PageList(
            $this->templateRenderer,
            new FeatTableBuilder(true)
        );
        return $page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
