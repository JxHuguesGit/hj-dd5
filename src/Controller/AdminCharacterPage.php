<?php
namespace src\Controller;

use src\Factory\CharacterFactory;
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
