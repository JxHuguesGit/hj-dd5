<?php
namespace src\Parser;

use src\Entity\RpgMonster;
use src\Constant\Field;
use src\Utils\Utils;

class MonsterCaracsParser
{
    private RpgMonster $rpgMonster;
    private \DOMDocument $dom;

    public function __construct(
        RpgMonster $rpgMonster,
        \DOMDocument $dom
    ) {
        $this->rpgMonster    = $rpgMonster;
        $this->dom           = $dom;
    }

    public static function parse(RpgMonster &$rpgMonster, \DOMDocument $dom): bool
    {
        $parser = new self($rpgMonster, $dom);
        return $parser->doParse();
    }

    public function doParse(): bool
    {
        $blnHasChanged = false;
        
        if ($this->parseCaracsPhysiques()) {
            $blnHasChanged = true;
        }
        if ($this->parseCaracsMentales()) {
            $blnHasChanged = true;
        }
        
        return $blnHasChanged;
    }

    private function parseCaracsPhysiques(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[contains(@class, 'car2') or contains(@class, 'car3')]");
        $values = [];
        foreach ($nodes as $node) {
            $values[] = trim($node->textContent);
        }
        // Normalement, il y a 9 valeurs
        if (count($values)!=9) {
            return $blnHasChanged;
        }
        
        $extra = $this->rpgMonster->getField(Field::EXTRA);
        $json = json_decode($extra, true);
        
        // 0 : score de force
        // 1 : bonus aux jets de carac de force
        // 2 : bonus aux jets de sauvegarde de force
        // 3 : score de dextérité
        // 4 & 5 : idem 1 & 2 pour la dextérité
        // 6 : score de constitution
        // 7 & 8 : idem 1 & 2 pour la constitution

        // Score de Force
        $score = $this->rpgMonster->getField(Field::STRSCORE);
        $value = $values[0];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::STRSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[1]);
        if ($mod!=$value) {
            $json['carstr'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[2]);
        if ($mod!=$value) {
            $json['jsstr'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Dextérité
        $score = $this->rpgMonster->getField(Field::DEXSCORE);
        $value = $values[3];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::DEXSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[4]);
        if ($mod!=$value) {
            $json['cardex'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[5]);
        if ($mod!=$value) {
            $json['jsdex'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Constitution
        $score = $this->rpgMonster->getField(Field::CONSCORE);
        $value = $values[6];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::CONSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[7]);
        if ($mod!=$value) {
            $json['carcon'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[8]);
        if ($mod!=$value) {
            $json['jscon'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        $extra = json_encode($json, JSON_UNESCAPED_UNICODE);
        $this->rpgMonster->setField(Field::EXTRA, $extra);
                
        return $blnHasChanged;
    }

    private function parseCaracsMentales(): bool
    {
        $blnHasChanged = false;
        
        $xpath = new \DOMXPath($this->dom);
        $nodes = $xpath->query("//div[contains(@class, 'car5') or contains(@class, 'car6')]");
        $values = [];
        foreach ($nodes as $node) {
            $values[] = trim($node->textContent);
        }
        // Normalement, il y a 9 valeurs
        if (count($values)!=9) {
            return $blnHasChanged;
        }
        
        $extra = $this->rpgMonster->getField(Field::EXTRA);
        $json = json_decode($extra, true);
                
        // 0 : score de intelligence
        // 1 : bonus aux jets de carac de intelligence
        // 2 : bonus aux jets de sauvegarde de intelligence
        // 3 : score de sagesse
        // 4 & 5 : idem 1 & 2 pour la sagesse
        // 6 : score de charisme
        // 7 & 8 : idem 1 & 2 pour la charisme
        
        // Score de Intelligence
        $score = $this->rpgMonster->getField(Field::INTSCORE);
        $value = $values[0];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::INTSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[1]);
        if ($mod!=$value) {
            $json['carint'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[2]);
        if ($mod!=$value) {
            $json['jsint'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Sagesse
        $score = $this->rpgMonster->getField(Field::WISSCORE);
        $value = $values[3];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::WISSCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[4]);
        if ($mod!=$value) {
            $json['carwis'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[5]);
        if ($mod!=$value) {
            $json['jswis'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        // Score de Charisme
        $score = $this->rpgMonster->getField(Field::CHASCORE);
        $value = $values[6];
        if ($score!=$value) {
            $this->rpgMonster->setField(Field::CHASCORE, $value);
            $blnHasChanged = true;
        }
        $mod = Utils::getModAbility($value);
        $value = str_replace(['+', '–'], ['', '-'], $values[7]);
        if ($mod!=$value) {
            $json['carcha'] = $value-$mod;
            $blnHasChanged = true;
        }
        $value = str_replace(['+', '–'], ['', '-'], $values[8]);
        if ($mod!=$value) {
            $json['jscha'] = $value-$mod;
            $blnHasChanged = true;
        }
        
        $extra = json_encode($json, JSON_UNESCAPED_UNICODE);
        $this->rpgMonster->setField(Field::EXTRA, $extra);
                
        return $blnHasChanged;
    }
}
