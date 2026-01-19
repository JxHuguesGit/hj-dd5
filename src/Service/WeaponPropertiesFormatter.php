<?php
namespace src\Service;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Utils\Html;

class WeaponPropertiesFormatter
{
    public function format(
        DomainWeaponPropertyValue $weaponPropertyValue,
        WpPostService $wpPostService
    ): string
    {
        $property = $this->getLink($weaponPropertyValue, $wpPostService);
        switch ($weaponPropertyValue->propertySlug) {
            case 'polyvalente' :
                $property .= $this->formatPolyvalente($weaponPropertyValue);
            break;
            case 'lancer' :
                $property .= $this->formatLancer($weaponPropertyValue);
            break;
            case 'munitions' :
                $property .= $this->formatMunitions($weaponPropertyValue);
            break;
            case 'finesse' :
            case 'legere' :
            case 'deux_mains' :
            case 'chargement' :
            case 'lourde' :
            case 'allonge' :
                // Rien à ajouter
            break;
            default :
        var_dump($weaponPropertyValue);
        echo '<br>';
        echo $weaponPropertyValue->propertySlug;
        echo '<br>';
            break;
        }
        return $property;
    }

    private function formatPolyvalente(DomainWeaponPropertyValue $weaponPropertyValue): string
    {
        return " (" . $weaponPropertyValue->diceCount
            . ($weaponPropertyValue->diceFaces > 1 ? "d" . $weaponPropertyValue->diceFaces : "") . ")";
    }

    private function formatLancer(DomainWeaponPropertyValue $weaponPropertyValue): string
    {
        return " (portée " . $this->feetToMeters($weaponPropertyValue->minRange)
            . "/" . $this->feetToMeters($weaponPropertyValue->maxRange) . ")";
    }

    private function feetToMeters(float $value)
    {
        return 3*$value/10;
    }

    private function formatMunitions(DomainWeaponPropertyValue $weaponPropertyValue): string
    {
        return substr($this->formatLancer(($weaponPropertyValue)), 0, -1) . " ; " . $weaponPropertyValue->ammunitionName . ")";
    }

    private function getLink(
        DomainWeaponPropertyValue $weaponPropertyValue,
        WpPostService $wpPostService
    ): string
    {
        $wpPostService->getById($weaponPropertyValue->postId);
        $linkContent = $weaponPropertyValue->propertyName
            . Html::getSpan($wpPostService->getPostContent() ?? '', [Constant::CST_CLASS=>'tooltip-text']);
        return Html::getLink($linkContent, '#', Bootstrap::CSS_TEXT_DARK.' tooltip-trigger');
    }
    
}
