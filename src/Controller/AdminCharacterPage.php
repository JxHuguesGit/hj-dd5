<?php
namespace src\Controller;

use src\Constant\Language as L;
use src\Factory\CharacterFactory;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

class AdminCharacterPage extends AdminPage
{
    public function __construct(
        private array $uri,
        private CharacterFactory $factory
    ) {
        parent::__construct($this->uri);
    }

    public function getAdminContentPage(string $content = ''): string
    {
        $nextStepId = '';
        if (Session::isPostSubmitted()) {
            $id = Session::fromPost('characterId', $this->arrParams['id'] ?? 0);
        } else {
            $id         = Session::fromGet('characterId', $this->arrParams['id'] ?? 0);
            $nextStepId = Session::fromGet('step', '');
            $action     = Session::fromGet('action', '');
            if ($action === 'confirmDeletion' && $id != 0) {
                $toastBuilder = new ToastBuilder(
                    new TemplateRenderer(),
                );
                $character = $this->factory->services()->reader()->characterById($id);
                $toastContent = $toastBuilder->success(sprintf(L::SUCCESS_DEL_ENTRY, $character->name));

                $this->factory->delete($character);

                $characterCreationFlow = $this->factory->init();
                $nextStepId = $characterCreationFlow->handle([]);
                $html = $characterCreationFlow->render($nextStepId, $toastContent);
                return parent::getAdminContentPage($html);
            }
        }

        if ($id != 0) {
            // Si on a une Session relative à un personnage, on récupère ce personnage.
            $characterCreationFlow = $this->factory->load((int) $id);
        } else {
            // Sinon, on créé un nouveau personnage à drafter.
            $characterCreationFlow = $this->factory->init();
        }

        if ($nextStepId == '') {
            $nextStepId = $characterCreationFlow->handle($_POST ?? []);
        }
        $html = $characterCreationFlow->render($nextStepId);

        return parent::getAdminContentPage($html);
    }
}
