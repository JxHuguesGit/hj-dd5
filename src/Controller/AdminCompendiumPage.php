<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Template;
use src\Factory\CompendiumFactory;

class AdminCompendiumPage extends AdminPage
{
    public function __construct(
        private array $uri,
        private CompendiumFactory $compendiumFactory
    ) {
        parent::__construct($this->uri);
    }

    public function getAdminContentPage(string $content = ''): string
    {
        switch ($this->getArrParams(Constant::ID)) {
            case Constant::ARMORS:
                $pageContent = $this->compendiumFactory->armor()->render();
                break;
            case Constant::WEAPONS:
                $pageContent = $this->compendiumFactory->weapon()->render();
                break;
            case Constant::SKILLS:
                $pageContent = $this->compendiumFactory->skill()->render();
                break;
            case Constant::GEAR:
                $pageContent = $this->compendiumFactory->gear()->render();
                break;
            case Constant::MONSTERS:
                $pageContent = $this->compendiumFactory->monster()->render();
                break;
            case Constant::FEATS:
                $pageContent = $this->compendiumFactory->feat()->render();
                break;
            case Constant::ORIGINS:
                $pageContent = $this->compendiumFactory->origin()->render();
                break;
            case Constant::TOOLS:
                $pageContent = $this->compendiumFactory->tool()->render();
                break;
            case Constant::SPELLS:
                $pageContent = $this->compendiumFactory->spell()->render();
                break;
            default:
                $pageContent = $this->homeContent();
                break;
        }

        // Dans cette méthode, on gère l'entête, le cadre noir : Image, couleurs, nom, espèce, classe, niveau
        // Tout le reste sera géré via d'autres méthodes afin de ne pas être perdu dans le nombre de paramètres du template
        $attributes  = [
            $pageContent,
            '',
        ];
        $content .= $this->getRender(Template::ADMINCOMPENDIUM, $attributes);
        return parent::getAdminContentPage($content);
    }

    private function homeContent(): string
    {
        return 'Que mettre ici ? Parce que techniquement, à part en modifiant l\'URL, on ne peut pas y arriver.';
    }

}
