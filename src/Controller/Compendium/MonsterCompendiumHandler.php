<?php
namespace src\Controller\Compendium;

use src\Constant\Constant;
use src\Page\PageList;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Service\Reader\MonsterReader;
use src\Utils\Session;

class MonsterCompendiumHandler implements CompendiumHandlerInterface
{
    private string $toastContent = '';

    public function __construct (
        private MonsterReader $reader,
        private MonsterListPresenter $presenter,
        private PageList $page,
    ) {}

    public function render(): string
    {
        $action = Session::fromGet(Constant::CST_ACTION);
        $slug   = Session::fromGet(Constant::CST_SLUG);

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $slug);
        }

        return match(true) {
            $action === Constant::EDIT && $slug !== '' => $this->renderEdit($slug),
            //$action === Constant::NEW => $this->renderCreate(new Item()),
            default => $this->renderList(),
        };
    }

    private function handleSubmit(string $action, string $slug): string
    {
        return '';
        /*
        return match ($action) {
            Constant::EDIT => $this->handleEditSubmit($slug),
            //Constant::NEW  => $this->handleNewSubmit(),
            default        => $this->renderList(),
        };
        */
    }

    private function renderEdit(string $slug): string
    {
        $monster = $this->reader->monsterByUkTag($slug);
        var_dump($monster);
/*
        $page = new PageForm(
            $this->templateRenderer,
            new FeatFormBuilder(
                new WpPostService(),
                $this->featTypeReader
            ),
            $this->toastContent
        );
        */
        return '';//$page->renderAdmin('', $feat);
    }

    private function renderList(): string
    {
        $monsters = $this->reader->allMonsters();
        $presentContent = $this->presenter->present($monsters);
        return $this->page->renderAdmin('', $presentContent, $this->toastContent);
    }
}
