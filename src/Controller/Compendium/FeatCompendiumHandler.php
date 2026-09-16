<?php
namespace src\Controller\Compendium;

use src\Collection\Collection;
use src\Constant\Language as L;
use src\Domain\Entity\Feat;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\FeatFormBuilder;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
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

    protected function handleEditSubmit(int $id): string
    {
        $feat = $this->featReader->featById($id);
        if (!$feat) {
            $this->toastContent = $this->toastBuilder->error("Le don modifié n'existe pas.");
            return $this->renderList();
        }

        $hasChanged = false;
        $hasErrors = false;

        $changedFields = [];
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field    = $value;
                $changedFields[] = $field;
                $hasChanged      = true;
            }
        }

        $selectedAbilities = new Collection();
        $abilitiesId = $this->getSelectedAbilities($selectedAbilities);

        $currentFeatAbilities = $this->featAbilityReader->featAbilitiesByFeatId($id);
        $currentAbilities = new Collection();
        foreach ($currentFeatAbilities as $featAbility) {
            $currentAbilities->add($this->abilityReader->abilityById($featAbility->abilityId));
        }
        if (!$currentAbilities->equals($selectedAbilities)) {
            $hasChanged = true;
        }

        if (!$hasChanged) {
            $this->toastContent = $this->toastBuilder->info(L::NO_MODIFICATION_ENTRY);
            $hasErrors = true;
        } elseif ($selectedAbilities->isEmpty()
            && ($feat->featTypeId==2 || $feat->featTypeId==4)) {
            $this->toastContent = $this->toastBuilder->info("Au moins une caractéristique doit être sélectionnée pour ce type de don.");
            $hasErrors = true;
        } else {
            //Sonar
        }

        if ($hasErrors) {
            return $this->renderEdit($id);
        }

        $this->featAbilityWriter->replaceFeatAbilities($id, $abilitiesId);
        $this->featWriter->updatePartial($feat, $changedFields);
        $this->toastContent = $this->toastBuilder->success("Le don <strong>" . $feat->name . "</strong> a été correctement mis à jour.");
        return $this->renderList();
    }

    private function getSelectedAbilities(Collection $selectedAbilities): array
    {
        $abilities = $this->abilityReader->allAbilities();
        $abilitiesId = [];
        foreach ($abilities as $ability) {
            $val = Session::fromPost($ability->slug);
            if ($val) {
                $selectedAbilities->add($ability);
                $abilitiesId[]       = $ability->id;
            }
        }
        return $abilitiesId;
    }

    protected function handleNewSubmit(): string
    {
        $feat = new Feat();
        foreach (Feat::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $feat->$field != $value) {
                $feat->$field    = $value;
                $changedFields[] = $field;
            }
        }

        $selectedAbilities = new Collection();
        $abilitiesId = $this->getSelectedAbilities($selectedAbilities);
        if ($selectedAbilities->isEmpty()
            && ($feat->featTypeId==2 || $feat->featTypeId==4)) {
            $this->toastContent = $this->toastBuilder->info("Au moins une caractéristique doit être sélectionnée pour ce type de don.");
            return $this->renderCreate();
        }

        $this->featWriter->insert($feat);
        $this->featAbilityWriter->replaceFeatAbilities($feat->id, $abilitiesId);
        $this->toastContent = $this->toastBuilder->success("Le nouveau don a été correctement créé.");
        return $this->renderList();
    }

    protected function renderCreate(): string
    {
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

        return $page->renderAdmin('', new Feat());
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
