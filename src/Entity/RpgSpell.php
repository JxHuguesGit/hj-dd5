<?php
namespace src\Entity;

use src\Controller\RpgSpell as ControllerRpgSpell;
use src\Enum\ClassEnum;

class RpgSpell extends Entity
{
    public int $id;
    public string $title;
    public ?string $content;
    public ?string $tempsIncantation;
    public ?string $portee;
    public ?string $duree;
    public ?int $niveau;
    public ?string $ecole;
    public ?array $classes;
    public ?array $composantes;
    public ?string $composanteMaterielle;
    public bool $concentration;
    public bool $rituel;
    public ?string $typeAmelioration;
    public ?string $ameliorationDescription;
    
    public function __construct(
        protected \Wp_Post $post
    ) {
        $this->id    = $post->ID;
        $this->title = $post->post_title;
        $this->content = $post->post_content;
        $this->content = apply_filters('the_content', $post->post_content);

        // Champs ACF
        $this->tempsIncantation = get_field('temps_dincantation', $post->ID);
        $this->portee           = get_field('portee', $post->ID);
        $this->duree            = get_field('duree', $post->ID);
        $this->niveau           = get_field('niveau', $post->ID);
        $this->ecole            = get_field('ecole', $post->ID);
        $this->classes          = get_field('classes', $post->ID);
        $this->composantes           = get_field('composantes', $post->ID);
        $this->composanteMaterielle = get_field('composante_materielle', $post->ID);
        $this->concentration    = !empty(get_field('concentration', $post->ID));
        $this->rituel           = !empty(get_field('rituel', $post->ID));
        $arr = get_field('type_damelioration', $post->ID);
        $this->typeAmelioration = (empty($arr) ? '' : $arr[0]);
        $this->ameliorationDescription = get_field('amelioration_description', $post->ID);
    }

    public function getController(): ControllerRpgSpell
    {
        $controller = new ControllerRpgSpell;
        $controller->setField('rpgSpell', $this);
        return $controller;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
    
    public function getNiveau() : ?int
    {
        return $this->niveau;
    }
    
    public function getEcole(): ?string
    {
        return $this->ecole;
    }
    
    public function getClasses(): array
    {
        return $this->classes;
    }
    
    public function getDescription(): string
    {
        return $this->content;
    }
    
    public function getTypeAmelioration(): string
    {
        return $this->typeAmelioration;
    }

    public function getAmelioration(): string
    {
        return $this->ameliorationDescription ?? '';
    }

    private function getDureeConvertie(string $value): string
    {
        if (strpos($value, 'min')) {
            $quantite = str_replace('min', '', $value);
            $unite = 'minute';
        } elseif (strpos($value, 'rd')) {
            $quantite = str_replace('rd', '', $value);
            $unite = 'round';
        } elseif (strpos($value, 'hr')) {
            $quantite = str_replace('hr', '', $value);
            $unite = 'heure';
        } elseif (strpos($value, 'jr')) {
            $quantite = str_replace('jr', '', $value);
            $unite = 'jour';
        } else {
            switch ($value) {
                case 'diss' :
                    $str = "Jusqu'à dissipation";
                break;
                case 'inst' :
                    $str = 'Instantanée';
                break;
                case 'spec' :
                    $str = 'Spéciale';
                break;
                case 'bonus' :
                    $str = 'Action Bonus';
                break;
                case 'action' :
                    $str = 'Action';
                break;
                case 'reaction' :
                    $str = 'Réaction';
                break;

                default :
                /*
    Jusqu'à 1 minute
    Jusqu'à 1 heure
    Jusqu'à 8 heures
    Dissipation/Déclenchement
                */
                    $str = $value;
                break;
            }
            return $str;
        }
        
        if ($quantite>1) {
            $unite .= 's';
        }
        
        return $quantite.' '.$unite;
    }
    
    public function getFormattedDuree(bool $detail=true): string
    {
        if ($this->concentration && $detail) {
            $str = "Concentration, jusqu'à ";
        } else {
            $str = '';
        }

        return $str . $this->getDureeConvertie($this->duree);
    }
    
    public function getFormattedComposantes(bool $detail=true): string
    {
        $str = implode(',', $this->composantes);
        if (in_array('M', $this->composantes) && $detail) {
            $str .= ' ('.$this->composanteMaterielle.')';
        }
        return $str;
    }
    
    public function getFormattedPortee(): string
    {
        switch ($this->portee) {
            case 'vue' :
            case 'contact' :
                $returned = ucwords($this->portee);
            break;
            case 'illim' :
                $returned = 'Illimitée';
            break;
            case 'perso' :
                $returned = 'Personnelle';
            break;
            case 'spec' :
                $returned = 'Spéciale';
            break;
            default :
                if (strpos($this->portee, 'km')!==false) {
                    $returned = substr($this->portee, 0, -2).' km';
                } else {
                    $returned = substr($this->portee, 0, -1).' m';
                }
                $returned = str_replace('.', ',', $returned);
            break;
        }
        return $returned;
    }
    
    public function getFormattedIncantation(): string
    {
        return $this->getDureeConvertie($this->tempsIncantation). ($this->rituel ? ' ou Rituel' : '');
    }
    
    public function getFormattedClasses(bool $parenthesis=true): string
    {
        $classes = array_map(
            fn(string $value) => ClassEnum::from($value)->label(),
            $this->classes
        );
        return $parenthesis ? '(' . implode(', ', $classes) . ')' : implode(', ', $classes);
    }
    
    public function getStrConcentration(): string
    {
        return $this->concentration ? 'Concentration' : '';
    }
    
    public function getStrRituel(): string
    {
        return $this->rituel ? 'Rituel' : '';
    }

}
