<?php
namespace src\Controller\Compendium;

use src\Constant\Constant as C;
use src\Domain\Criteria\SpellCriteria;
use src\Domain\Entity\Spell;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\SpellFormBuilder;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\SpellService;
use src\Utils\Session;

final class SpellCompendiumHandler
    implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private SpellService $spellService,
        private SpellListPresenter $spellListPresenter,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer,
        private SpellFormBuilder $spellFormBuilder,
    ) {}

    public function render(): string
    {
        $action = Session::fromGet(C::ACTION);
        $slug   = Session::fromGet(C::SLUG);

        $criteria = new SpellCriteria();
        $criteria->id = (int) $slug;
        $spell = $this->spellService->allSpells($criteria)->collection?->first() ?? new Spell();

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $spell);
        }

        return match (true) {
            $action === C::EDIT && $slug !== '' => $this->renderEdit($spell),
            $action === C::NEW                  => $this->renderEdit($spell),
            default                             => $this->renderList(),
        };
    }

    protected function handleSubmit(string $action, Spell $spell): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit($spell),
            C::NEW  => $this->handleNewSubmit($spell),
            default => $this->renderList(),
        };
    }

    private function controlEntity(Spell $spell): bool
    {
        $blnOk = true;
        if ($spell->schoolId==0) {
            $this->toastContent .= $this->toastBuilder->warning("L'école du sort doit être saisie.");
            $blnOk = false;
        }
        if ($spell->sourceId==0) {
            $this->toastContent .= $this->toastBuilder->warning("L'origine du sort doit être saisie.");
            $blnOk = false;
        }
        if ($spell->castingTimeId==0) {
            $this->toastContent .= $this->toastBuilder->warning("Le temps d'incantation du sort doit être saisie.");
            $blnOk = false;
        }
        if ($spell->castingTimeId==3 && $spell->spellTriggerId==0) {
            $this->toastContent .= $this->toastBuilder->warning("Le déclenchement doit être saisi pour un sort ayant un temps d'incantation 'Réaction'.");
            $blnOk = false;
        }
        if ($spell->rangeId==0) {
            $this->toastContent .= $this->toastBuilder->warning("La portée du sort doit être saisie.");
            $blnOk = false;
        }
        if ($spell->durationId==0) {
            $this->toastContent .= $this->toastBuilder->warning("La durée du sort doit être saisie.");
            $blnOk = false;
        }
        return $blnOk;
    }

    private function initEntity(Spell $spell, ?array &$changedFields = null): void
    {
        foreach (Spell::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $spell->$field != $value) {
                $spell->$field    = $value;
                if ($changedFields !== null) {
                    $changedFields[] = $field;
                }
            }
        }
    }

    protected function handleEditSubmit(Spell $spell): string
    {
        $blnOk = true;
        $changedFields = [];
        $this->initEntity($spell, $changedFields);
        if ($changedFields == []) {
            $this->toastContent .= $this->toastBuilder->error("Aucune nouvelle modification.");
            $blnOk = false;
        } elseif (!$this->controlEntity($spell)) {
            $this->toastContent .= $this->toastBuilder->error("Un champ obligatoire n'a pas été saisi ou a une valeur erronnée.");
            $blnOk = false;
        }
        if (!$blnOk) {
            return $this->renderEdit($spell);
        }

        $this->toastContent = $this->toastBuilder->success("Mise à jour du sort en cours de développement.");
        return $this->renderEdit($spell);
    }

    protected function handleNewSubmit(Spell $spell): string
    {
        $this->initEntity($spell);

        if (!$this->controlEntity($spell)) {
            $this->toastContent .= $this->toastBuilder->error("Erreur lors de la création du sort.");
            return $this->renderEdit($spell);
        }

        $this->toastContent = $this->toastBuilder->success("Le nouveau sort a été correctement créé.");
        return $this->renderEdit($spell);
    }

    protected function renderEdit(Spell $spell): string
    {
        $page = new PageForm(
            $this->templateRenderer,
            $this->spellFormBuilder,
            $this->toastContent
        );

        return $page->renderAdmin('', $spell);
    }

    protected function renderList(): string
    {
        $criteria = new SpellCriteria();
        $result   = $this->spellService->allSpells($criteria);
        $presentContent = $this->spellListPresenter->present($result->collection);

        $page = new PageList(
            $this->templateRenderer,
            new SpellTableBuilder(true)
        );

        return $page->renderAdmin(
            '',
            $presentContent,
            $this->toastContent
        );
    }
}
