<?php
namespace src\CharacterCreation;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Entity\RpgHeros;
use src\Repository\RpgHeros as RepositoryRpgHeros;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Utils\Session;

class SpeciesStep extends AbstractStep
{
    public function validateAndSave(): void
    {
        if (!Session::isPostSubmitted()) {
            return; // Rien à valider
        }
        
        // On récupère et nettoie la valeur
        $speciesId = (int) trim(Session::fromPost('characterSpeciesId', ''));
        if ($speciesId <= 0) {
            // Pas d’erreur UI ici → juste pas de progression d’étape
            return;
        }

        $species = $this->deps['species']->find($speciesId);
        if (!$species) {
            return;
        }

        $this->hero->setField(Field::SPECIESID, $speciesId);
        $this->hero->setField(Field::CREATESTEP, 'originFeat');
        $this->hero->setField(Field::LASTUPDATE, time());
        $this->deps['heroRepo']->update($this->hero);
    }

    public function renderStep(): array
    {
        $sidebar = (new SidebarRenderer($this->hero, $this->deps, $this->renderer, $this->stepMap))->render();

        $rpgSpecies = $this->deps['speciesRepo']->findBy([Field::PARENTID=>0], [Field::NAME=>Constant::CST_ASC]);
        $selSpeciesId = $this->hero->getField(Field::SPECIESID);

        $primarySpeciesHtml = '';
        $subspeciesHtml = '';
        // Construction de la liste des options d'origines avec sélection si donnée présente.
        foreach ($rpgSpecies as $element) {
            $primarySpeciesHtml .= $element->getController()->getRadioForm($selSpeciesId==$element->getField(Field::ID));
            $rpgSubSpecies = $this->deps['speciesRepo']->findBy([Field::PARENTID=>$element->getField(Field::ID)], [Field::NAME=>Constant::CST_ASC]);
            $subspeciesHtml .= $this->buildSubspeciesHtml($rpgSubSpecies, $selSpeciesId, $element->getField(Field::NAME), $element->getField(Field::ID));
        }

        return [
            'template'  => Template::CREATE_SPECIES,
            'variables' => [
                'sidebar'       => $sidebar,
                'heroId'        => $this->hero->getField(Field::ID),
                'boutonsRadio'  => $primarySpeciesHtml,
                'boutonsRadio2' => $subspeciesHtml,
            ],
        ];
    }

    public static function getSidebarLabel(): string
    {
        return 'Espèce';
    }

    public function getSidebarValue(): string
    {
        return $this->hero->getSpecies()?->getFullName();
    }

    private function buildSubSpeciesHtml(Collection $subspecies, int $selectedId, string $parentName, int $parentId): string
    {
        if ($subspecies->isEmpty()) {
            return '';
        }

        $subspeciesHtml  = '<div class="subspecies-group" data-species="'.$parentId.'" style="display:none;">';
        $subspeciesHtml .= '<h5>'.htmlspecialchars($parentName).'</h5>';
        foreach ($subspecies as $subElement) {
            $subspeciesHtml .= $subElement->getController()->getRadioForm($selectedId==$subElement->getField(Field::ID));
        }
        $subspeciesHtml .= '</div>';

        return $subspeciesHtml;
    }
}
