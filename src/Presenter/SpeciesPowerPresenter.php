<?php
namespace src\Presenter;

use src\Constant\Field;
use src\Controller\Utilities;
use src\Constant\Template;
use src\Entity\RpgPower;
use src\Repository\RpgPower as RepositoryRpgPower;

class SpeciesPowerPresenter
{
    private Utilities $util;
    private RepositoryRpgPower $repo;

    public function renderList(array $powers, RepositoryRpgPower $repo): string
    {
        $this->util = new Utilities();
        $this->repo = $repo;

        $output = '';
        foreach ($powers as $power) {
            $output .= $this->render($power);
        }
        return $output;
    }

    public function render(RpgPower $power): string
    {
        // On récupère les sous pouvoirs
        $subs = $this->repo->findBy([Field::PARENTID => $power->getId()]);
        // Si pas de sous pouvoirs, on cache la subliste dans le template.
        $strShowSubList = $subs->isEmpty() ? ' d-none' : '';
        // Si sous pouvoirs, on affiche la subliste dans le template.
        $strSubList = $this->renderSubList($subs);

        $this->util = new Utilities();
        return $this->util->getRender(
            Template::SPECIES_POWER_CARD,
            [
                htmlspecialchars($power->getName()),
                nl2br(htmlspecialchars($power->getDescription())),
                $strShowSubList,
                $strSubList,
                $subs->isEmpty() ? ' col-md-6' : '',
            ],
        );
    }

    public function renderSubList($subs): string
    {
        $output = '';
        foreach ($subs as $sub) {
            $output .= '<li><strong>' . htmlspecialchars($sub->getName()) . '.</strong> ' . htmlspecialchars($sub->getDescription()) . '</li>';
        }
        return $output;
    }
}
