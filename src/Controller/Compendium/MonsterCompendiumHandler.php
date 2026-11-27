<?php

namespace src\Controller\Compendium;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Domain\Entity\MonsterSpeedType;
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
            if (in_array($field, [F::LEGENDARY])) {
                // Gestion des booléens
                $monster->$field = ($value === $field ? 1 : 0);
            } elseif ($value != 'err' && $monster->$field != $value) {
                // Champ standard
                $monster->$field    = $value;
                if ($changedFields !== null) {
                    $changedFields[] = $field;
                }
            }
        }

        $this->initExtra($monster, $changedFields);
        $this->initSpeed($monster, $changedFields);
    }

    private function initExtra(Monster $monster, array &$changedFields): void
    {
        $extra = Session::fromPost(F::EXTRA);
        foreach ($extra as $key => $value) {
            $stored = $monster->getExtra($key);
            if ('' !== $value && $stored != $value) {
                $monster->setExtra($key, $value);
                if ($changedFields !== null && !isset($changedFields[$key])) {
                    $changedFields[] = $key;
                }
            }
        }
    }

    private function initSpeed(Monster $monster, array &$changedFields): void
    {
        $speed = Session::fromPost(F::SPEED);
        $value = Session::fromPost(F::VALUE);
        $comp  = Session::fromPost('comp');
        // On a la liste des identifiants dans les value et les types de déplacement dans les key
        $speedTypes = $this->readerFactory->speedType()->allSpeedTypes();

        $newMonsterTypeSpeeds = new Collection();
        foreach ($speedTypes as $speedType) {
            $monsterSpeedType = $monster->speed($speedType->id);
            if ((
                $value[$speedType->frTag] != $monsterSpeedType->value ||
                $comp[$speedType->frTag] != $monsterSpeedType->extra
            ) && !isset($changedFields['updateSpeed'])) {
                $changedFields[] = 'updateSpeed';
            }
            $attributes = [
                F::MONSTERID   => $monster->id,
                F::TYPESPEEDID => $speedType->id,
                F::VALUE       => (float) $value["'" . $speedType->frTag . "'"],
                F::EXTRA       => $comp["'" . $speedType->frTag . "'"]
            ];
            $newMonsterTypeSpeeds->add(new MonsterSpeedType($attributes));
        }

        if (isset($changedFields['updateSpeed'])) {
            $monster->setSpeedTypeEntities($newMonsterTypeSpeeds);
        }
    }

    private function controlSpeed(Monster $monster): bool
    {
        return true;
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
        if (isset($changedFields['updateSpeed'])) {
            unset($changedFields['updateSpeed']);
            if (!$this->controlSpeed($monster)) {
                $this->toastContent .= $this->toastBuilder->error("Une Vitesse a été mal saisie.");
                return $this->renderEdit($monster);
            }
        }

        var_dump($changedFields);
        //$this->writer->updatePartial($monster, $changedFields);
        $this->toastContent .= $this->toastBuilder->success("Le monstre a été correctement mis à jour.");
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
