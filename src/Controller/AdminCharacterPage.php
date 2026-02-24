<?php
namespace src\Controller;

use src\Factory\CharacterDraftFactory;
use src\Utils\Session;

class AdminCharacterPage extends AdminPage
{
    public function __construct(
        private array $uri,
        private CharacterDraftFactory $characterDraftFactory
    ) {
        parent::__construct($this->uri);
    }

    public function getAdminContentPage(string $content=''): string
    {
        $nextStepId = '';
        if (Session::isPostSubmitted()) {
            $id = Session::fromPost('characterId', $this->arrParams['id']??0);
        } else {
            $id = Session::fromGet('characterId', $this->arrParams['id']??0);
            $nextStepId = Session::fromGet('step', '');
        }

        if ($id!=0) {
            // Si on a une Session relative à un personnage, on récupère ce personnage.
            $characterCreationFlow = $this->characterDraftFactory->load((int)$id);
        } else {
            // Sinon, on créé un nouveau personnage à drafter.
            $characterCreationFlow = $this->characterDraftFactory->init();
        }

        if ($nextStepId=='') {
            $nextStepId = $characterCreationFlow->handle($_POST ?? []);
        }
        $html = $characterCreationFlow->render($nextStepId);

        return parent::getAdminContentPage($html);
    }
}
