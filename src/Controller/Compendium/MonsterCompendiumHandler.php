<?php

namespace src\Controller\Compendium;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Monster\Monster;
use src\Factory\ReaderFactory;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\FormBuilder\MonsterFormBuilder;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Presenter\Modal\MonsterFilterModalPresenter;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\MonsterReader;
use src\Service\Writer\MonsterWriter;
use src\Utils\Session;

class MonsterCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct(
        private MonsterWriter $writer,
        private MonsterReader $reader,
        private MonsterListPresenter $presenter,
        private PageList $page,
        private MonsterFilterModalPresenter $modalPresenter,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer,
        private ReaderFactory $readerFactory,
    ) {}

    public function render(): string
    {
        $action = Session::fromGet(C::ACTION);
        $slug   = (int) Session::fromGet(C::SLUG);

        $monster = $this->reader->monsterById($slug);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $monster);
        }

        return match (true) {
            $action === C::EDIT && $slug !== '' => $this->renderEdit($monster),
            $action === C::NEW                  => $this->renderEdit($monster),
            default                             => $this->renderList(),
        };
    }

    protected function handleSubmit(string $action, Monster $monster): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit($monster),
            //C::NEW  => $this->handleNewSubmit($monster),
            default => $this->renderList(),
        };
    }
    private function initEntity(Monster $monster, ?array &$changedFields = null): void
    {
        foreach (Monster::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            // Gestion des booléens
            if (in_array($field, [F::LEGENDARY])) {
                $monster->$field = ($value === $field ? 1 : 0);
            } elseif ($value != 'err' && $monster->$field != $value) {
                // Champ standard
                $monster->$field    = $value;
                if ($changedFields !== null) {
                    $changedFields[] = $field;
                }
            }
        }
    }

    private function controlEntity(Monster $monster): bool
    {
        $blnOk = true;
        if ($monster->frName == '') {
            $this->toastContent .= $this->toastBuilder->warning("Le nom français doit être saisi.");
            $blnOk = false;
        }
        if ($monster->reference()->getId() == 0) {
            $this->toastContent .= $this->toastBuilder->warning("La source doit être saisie.");
            $blnOk = false;
        }
        return $blnOk;
    }

    protected function handleEditSubmit(Monster $monster): string
    {
        $changedFields = [];
        $this->initEntity($monster, $changedFields);

        if (!$this->controlEntity($monster)) {
            $this->toastContent .= $this->toastBuilder->error("Un champ obligatoire n'a pas été saisi ou a une valeur erronnée.");
            return $this->renderEdit($monster);
        }

        $this->writer->updatePartial($monster, $changedFields);
        $this->toastContent = $this->toastBuilder->success("Le monstre a été correctement mis à jour.");
        return $this->renderEdit($monster);
    }

    protected function renderEdit(Monster $monster): string
    {
        $page = new PageForm(
            $this->templateRenderer,
            new MonsterFormBuilder($this->readerFactory),
            $this->toastContent
        );
        return $page->renderAdmin('', $monster);
    }

    protected function renderList(): string
    {
        $monsters       = $this->reader->allMonsters();
        $presentContent = $this->presenter->present($monsters);
        return $this->page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
