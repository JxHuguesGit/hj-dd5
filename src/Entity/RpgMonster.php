<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonster as ControllerRpgMonster;
use src\Helper\SizeHelper;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgAlignement as RepositoryRpgAlignement;
use src\Repository\RpgReference as RepositoryRpgReference;
use src\Repository\RpgSousTypeMonstre as RepositoryRpgSousTypeMonstre;
use src\Repository\RpgTypeMonstre as RepositoryRpgTypeMonstre;

class RpgMonster extends Entity
{
	public string $msgErreur;

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $frTag,
        protected string $ukTag,
        protected int $incomplet,
        protected float $cr,
        protected int $monstreTypeId,
        protected int $monsterSubTypeId,
        protected int $swarmSize,
        protected int $monsterSize,
        protected int $alignmentId,
        protected int $ca,
        protected int $hp,
        protected int $vitesse,
        protected int $initiative,
        protected int $legendary,
        protected string $habitat,
        protected int $referenceId,
        protected ?string $extra
    ) {

    }

    public function getController(): ControllerRpgMonster
    {
        $controller = new ControllerRpgMonster;
        $controller->setField('rpgMonster', $this);
        return $controller;
    }
    
    public function getExtra($field): string
    {
    	if ($this->extra==null) {
        	return '';
        }
        $tabExtra = json_decode($this->extra, true);
        return $tabExtra[$field]??'';
    }
    
    public function getStrExtra(string $field): string
    {
    	$value = $this->{$field};
        $extra = $this->getExtra($field);
        if ($extra!='') {
        	$value .= ' ' . $extra;
        }        
        return $value;
    }

    public function getFormatCr(): string
    {
        switch ($this->cr) {
            case -1 :
                $returned = '-';
            break;
            case 0.125 :
                $returned = '1/8';
            break;
            case 0.25 :
                $returned = '1/4';
            break;
            case 0.5 :
                $returned = '1/2';
            break;
            default :
                $returned = $this->cr;
            break;
        }
        return $returned;
    }

    public function getAlignement(): ?RpgAlignement
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgAlignement($queryBuilder, $queryExecutor);
        return $objDao->find($this->alignmentId);
    }

    public function getReference(): ?RpgReference
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgReference($queryBuilder, $queryExecutor);
        return $objDao->find($this->referenceId);
    }

    public function getStrType(): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        // Récupération du type de monstre (et de son genre pour accord en français)
        $objDao = new RepositoryRpgTypeMonstre($queryBuilder, $queryExecutor);
        /** @var RpgTypeMonstre $objTypeMonstre */
        $objTypeMonstre = $objDao->find($this->monstreTypeId);
        $gender = '';
        $strType = $objTypeMonstre->getStrName($gender);
        //////////////////////

        // Si le monstre est une nuée
        if ($this->swarmSize!=0) {
            $strType = 'Nuée de '.SizeHelper::toLabelFr($this->swarmSize, $gender).'s '.$strType.'s';
        }
        //////////////////////

        // Si le monstre a un sous-type
        if ($this->monsterSubTypeId!=0) {
            $objDao = new RepositoryRpgSousTypeMonstre($queryBuilder, $queryExecutor);
            /** @var RpgSousTypeMonstre $objSousTypeMonstre */
            $objSousTypeMonstre = $objDao->find($this->monsterSubTypeId);
            $strType .= ' ('.$objSousTypeMonstre->getStrName().')';
        }
        //////////////////////

        return $strType;
    }
    
    public function getSizeTypeAndAlignement(): string
    {
        $strSTAA  = $this->getStrType() . ' de taille ';
        $strSTAA .= SizeHelper::toLabelFr($this->monsterSize);
        $obj = $this->getAlignement();
    	return $strSTAA.', '.$obj->getStrAlignement(); 
    }
    
    public function getStrModifier(int $value): string
    {
    	return ($value>=0 ? '+' : '').$value;
    }
    
    public function getStrInitiative(): string
    {
    	if ($this->initiative>=0) {
        	return '+'.$this->initiative;
        } else {
        	return $this->initiative;
        }
    }

    public function getStrVitesse(): string
    {
    	$value = $this->vitesse.'m';
        $extra = $this->getExtra('vitesse');
        if ($extra!='') {
        	$value .= ', ' . $extra;
        }      
        return $value;
    }
    
    public function parseFile(string $urlSource, bool $blnFr=false): bool
    {
    	$data = [];
    	$handle = fopen('https://dd5.jhugues.fr/wp-content/plugins/hj-dd5/assets/aidedd/'.$this->ukTag.'.html', 'r');  
        while (true) {
            $line = fgets($handle, 2048);
            if ($line===false) {
                break;
            }
            
            ///////////////////////////////////
            //
            $pattern = "~<h1>([^<]+)</h1>.*?"
                . "<div class=['\"]type['\"]>([^<]+)</div>.*?"
                . "(?:<div class=['\"]init['\"]><strong>Initiative</strong>\s*([^<]+)</div>.*?)?"
                . "<strong>(?:AC|CA)</strong>\s*([^<]+)<br>.*?"
                . "<strong>(?:HP|PV)</strong>\s*([^<]+)<br>.*?"
                . "<strong>(?:Speed|Vitesse)</strong>\s*([^<]+)<br>~is";            
            
            if (preg_match($pattern, $line, $matches)) {
            	$data = array_merge($data, [
                    'name'       => $matches[1],
                    'type'       => $matches[2],
                    'initiative' => isset($matches[3]) ? trim($matches[3]) : null,
                    'ac'         => trim($matches[4]),
                    'hp'         => trim($matches[5]),
                    'speed'      => trim($matches[6]),
                ]);
            }
            ///////////////////////////////////
            
            ///////////////////////////////////
            //
            $pattern = "/<div class='car1'>(\w+)<\/div><div class='car2'>(\d+)<\/div><div class='car3'>([+-]?\d+)<\/div><div class='car3'>([+-]?\d+)<\/div>/";
            if (preg_match_all($pattern, $line, $matches, PREG_SET_ORDER)) {
                $caracs = [];
                foreach ($matches as $match) {
                    $attr = $match[1];
                    $caracs[$attr] = [
                        'val' => (int)$match[2],
                        'mod1' => (int)$match[3],
                        'mod2' => (int)$match[4],
                    ];
                }
                $data = array_merge($data, $caracs);
            }
            ///////////////////////////////////
            
            ///////////////////////////////////
            //
            $pattern = "/<div class='car4'>(\w+)<\/div><div class='car5'>(\d+)<\/div><div class='car6'>([+-]?\d+)<\/div><div class='car6'>([+-]?\d+)<\/div>/";
            if (preg_match_all($pattern, $line, $matches, PREG_SET_ORDER)) {
                $caracs = [];
                foreach ($matches as $match) {
                    $attr = $match[1];
                    $caracs[$attr] = [
                        'val' => (int)$match[2],
                        'mod1' => (int)$match[3],
                        'mod2' => (int)$match[4],
                    ];
                }
                $data = array_merge($data, $caracs);
            }
            ///////////////////////////////////
            
            ///////////////////////////////////
            //
            $pattern = "/>(Skills|Compétences|Senses|Sens|Languages|Langages|Immunities|Immunités|Resistances|Résistances|Vulnerabilities|Vulnérabilités|CR|FP|Gear|Equipement)<\/strong>\s*([^\r\n<]+)/i";
            if (preg_match($pattern, $line, $matches)) {
                $key = $matches[1];
                $values = $matches[2];
				$result = [$key => $values];
                $data = array_merge($data, $result);
            }
            ///////////////////////////////////
            
            ///////////////////////////////////
            //
            $pattern = "/<div class='rub'>(Traits|Actions|Reactions|Bonus actions)<\/div>(.*?)(?=<div class='rub'>|<\/div><div class='description'>|$)/si";
            if (preg_match_all($pattern, $line, $blocks, PREG_SET_ORDER)) {
            	$subPattern = "/<p>\s*<strong><em>(.*?)<\/em><\/strong>(.*?)<\/p>/si";
				$result = [];
                foreach ($blocks as $block) {
                    $section = $block[1];
                    $content = $block[2];
                    if (preg_match_all($subPattern, $content, $entries, PREG_SET_ORDER)) {
                        foreach ($entries as $entry) {
                            $title = trim(strip_tags($entry[1]));
                            $body = trim(strip_tags($entry[2]));
                            $result[$section][$title] = $body;
                        }
                    }
                }
                $data = array_merge($data, $result);
            }
		}
        fclose($handle);
        
        return $this->analyseParsedFile($data, $blnFr);
    }
    
    private function analyseParsedFile(array $data, bool $blnFr): bool
    {
    	$hasError = false;
        $this->msgErreur = '';
        
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgMonster($queryBuilder, $queryExecutor);

		$blnUpdate = false;
    	//var_dump($data);
        
        // Vérification du nom
        /*
        $name = $data['name'];
        $storedName = $blnFr ? $this->frName : $this->name;
        if ($storedName!=$name) {
        	if ($blnFr) {
            	$this->frName = $name;
            } else {
            	$this->name = $name;
            }
        }
        */
        
        // type
        // initiative
        if (preg_match("/[+-](\d+)/", $data['initiative'], $matches)) {
	        $value = $matches[1];
            if ($this->getField(Field::INITIATIVE)!=$value) {
                $this->initiative = $value;
                $blnUpdate = true;
            }
        }
        // ac
        // hp
        // speed
        $hasError = $this->analyserVitesse($data['speed']) || $hasError;
        //
        
        if (!$hasError && $blnUpdate) {
        	$objDao->update($this);
        }
        
        return $hasError;
    }
    
    private function analyserVitesse(string $strSpeed): bool
    {
    	$blnHasError = false;
    	$pattern = "/(?:(?:^|,\s*)(?:(Fly|Climb|Swim)\s*)?(\d+)\s*(ft\.|m\.))/i";
        if (preg_match_all($pattern, $strSpeed, $matches, PREG_SET_ORDER)) {
        	// Il faudrait supprimer toutes les vitesses attachées à ce monstre
        	$result = [];
            foreach ($matches as $index => $match) {
            	$mult = $match[3]=='m' ? 1 : 0.3;
            	switch ($match[1]) {
                	case 'Fly' :
                    case 'Vol' :
                    // rpgTypeSpeed : id = 1
                    // Ajouter la vitesse au monstre
                        $this->msgErreur .= "Vitesse de vol : ".$match[2] * $mult;
                        $blnHasError = true;
                    break;
                    case '' :
                    	$this->speed = $match[2] * $mult;
                    break;
                    default :
                        $this->msgErreur .= "Type de vitesse non géré : ".$match[1];
                        $blnHasError = true;
                    break;
                }
            }
        } else {
	        $this->msgErreur .= "Erreur Vitesse : ".$data['speed'];
        	$blnHasError = true;
        }
        return $blnHasError;
    }
    
    
}