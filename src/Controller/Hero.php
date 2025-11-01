<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Controller\Caste as ControllerCaste;
use src\Entity\Hero as EntityHero;
use src\Enum\AbilityEnum;
use src\Enum\SkillEnum;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\Caste;
use src\Repository\Hero as RepositoryHero;
use src\Utils\Session;
use src\Utils\Translation;
use src\Utils\Utils;

class Hero extends Utilities
{
    private int $heroSelection;
    public EntityHero $entityHero;
    private string $bgColor = '';
    private string $fontColor = '';
    private array $defaultColor = [];

    public function __construct()
    {
        parent::__construct();

        // TODO : Plus tard, il faudra vérifier les variables de Session pour prendre ce qu'il y a en Session à la place de prendre ce qui vient du formulaire.
        $this->heroSelection = Session::fromPost(Constant::HEROSELECTION, -1);

        $this->title = 'Home';
    }

    public function getContentHeader(): string
    {
        return $this->getRender(Template::HERO_CREATE_HEADER);
    }

    public function getContentPage(string $msgProcessError=''): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $repository = new RepositoryHero($queryBuilder, $queryExecutor);

        // Donc, ici, on va regarder $heroSelection.
        if ($this->heroSelection==-1) {
            $wpUser = Session::getWpUser();
            // On va créer un nouveau Hero
            // Mais on doit vérifier que le nom n'est pas déjà pris.
            $heroName = $repository->getNextName($wpUser->data->user_nicename);
            $hero = new EntityHero(0, $heroName, 0, $wpUser->ID, time(), 0);
            $repository->insert($hero);
            $repository->reset();
            $this->heroSelection = $hero->getId();
        } else {
            // Sinon, on vérifie que heroSelection appartient au user courant.
            // TODO : Si ce n'est pas le cas, on repart sur HomePage.
            // On précise le type de l'entité retourné pour ne pas avoir de faux positifs sur des méthodes appelées plus bas.
            /** @var EntityHero|null $hero */
            $hero = $repository->find($this->heroSelection);
        }
        // Faudrait enregistrer l'id du hero en session, pour rester dessus.
        Session::setSession('sessionHeroId', $hero->getId());

        // A partit de là, on doit déterminer ce que l'on doit afficher.
        if ($hero->getCreateStep()==0) {
            // Ici, createStep vaut 0, on est donc clairement à la première étape de la phase de création du personnage !
            // Donc on doit proposer l'interface qui permet de choisir sa classe.
            return $this->getCreateForm();
        } elseif ($hero->getCreateStep()==-1) {
            // On n'est plus en mode création
            return "TODO : On n'est plus en mode Création... On fait quoi maintenant ?";
        } else {
            return ControllerCaste::getCreationContentForCaste()->getContentPage();
        }
    }

    public function getCreateForm(): string
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();

        // On récupère la liste des classes disponibles.
        $casteRepo = new Caste($queryBuilder, $queryExecutor);
        $collection = $casteRepo->findAll();
        $collection->rewind();

        $casteSelection = '';
        while ($collection->valid()) {
            $caste = $collection->current();
            $attributes = [
                $caste->getCode(),
                Translation::translate('caste.name.'.strtolower($caste->getCode()), 'fr'),
                $caste->getId(),
            ];
            $casteSelection .= $this->getRender(Template::CASTE_SELECT_BTN, $attributes);
            $collection->next();
        }

        $attributes = [
            $casteSelection,
            'classSelection',
        ];
        return $this->getRender(Template::HERO_CREATE_FORM, $attributes);
    }

    public function getHeroSelectionLine(): string
    {
        return $this->getRender(Template::HERO_SELECTION_LINE, $this->entityHero->getFieldValues([Field::ID, Field::NAME]));
    }
    
    public function getNameBlock(): array
    {
        $urlImg = '/wp-content/plugins/hj-dd5/assets/images/PJ1avatar.jpeg';
        $scheme = $this->entityHero->getSchemeColor();
        if ($scheme=='ct-scheme-lightblue') {
            $this->bgColor = '#FEFEFE';
            $this->fontColor = '#53a5c5';
        }
        $this->defaultColor = [
            $this->bgColor, // Couleur de fond
            $this->fontColor, // Couleur de contour
        ];
        
        // Dans cette méthode, on gère l'entête, le cadre noir : Image, couleurs, nom, espèce, classe, niveau
        return [
            $this->entityHero->getId(),
            $scheme,
            $urlImg, // image du personnage
            $this->entityHero->getField(Field::NAME), // nom du personnage
            'Humaine', // espèce du personnage
            'Roublard 1', // classe du personnage
            'Niveau 1', // niveau du personnage
        ];
    
    }
    
    public function getQuickInfoBlock(): string
    {
        $strQuickInfos = '';
        
        $abilities = AbilityEnum::cases();
        while (!empty($abilities)) {
            $ability = array_shift($abilities);
            
            $label = $ability->label();
            $value = $this->entityHero->getAbility($ability->value);
            $modAbility = Utils::getModAbility($value);
            $ariaLabel = Utils::formatStringAbility($modAbility);
            $mod = Utils::formatStringModAbility($modAbility);
            $attributes = [$label, $mod, $ariaLabel, $value];
            
            $strQuickInfos .= $this->getRender(Template::ADMINCHARABILITY, array_merge($this->defaultColor, $attributes));
        }
        
        $proficiencyBonus = $this->entityHero->getProficiencyBonus();
        $attributes = [
            Utils::formatStringAbility($proficiencyBonus),
            Utils::formatStringModAbility($proficiencyBonus)
        ];
        $strProficiencyBonus = $this->getRender(Template::ADMINCHARPROFBONUS, array_merge($this->defaultColor, $attributes));

        $attributes = [
            '9', // nombre de mètres de déplacement
        ];
        $strSpeed = $this->getRender(Template::ADMINCHARSPEED, array_merge($this->defaultColor, $attributes));

        $strHeroicInspiration = $this->getRender(Template::ADMINCHARHEROICINS, $this->defaultColor);

        $attributes = [
            $strQuickInfos,
            $strProficiencyBonus,
            $strSpeed,
            $strHeroicInspiration,
        ];
        return $this->getRender(Template::ADMINQUICKINFO, $attributes);
    }

    public function getSubsectionsBlock(): string
    {
        $attributes = [
            $this->getSubSectionAbilitiesBlock(),
            $this->getSubSectionPassiveBlock(),
            $this->getSubSectionMaterielLanguesBlock(),
            $this->getSubSectionSkillsBlock(),
            $this->getSubSectionCombatBlock(),
            '',
            '',
            ''
        ];
        return $this->getRender(Template::ADMINCHARSUBSECTION, $attributes);
    }
    
    private function getSubSectionMaterielLanguesBlock(): string
    {
        $attributesMerged = array_merge(
            $this->defaultColor,
            [
                'A',
                'B',
                'C',
            ]
        );
        return $this->getRender(Template::ADMINCHARSUBSECMLG, $attributesMerged);
    }
    
    private function getSubSectionPassiveBlock(): string
    {
        $attributesMerged = array_merge(
            $this->defaultColor,
            [
                'A',
                'B',
                'C',
            ]
        );
        return $this->getRender(Template::ADMINCHARSUBSECPSV, $attributesMerged);
    }
    
    private function getSubSectionCombatBlock(): string
    {
        $attributesMerged = array_merge(
            $this->defaultColor,
            [
                'plus 2',
                '+2',
                '13',
            ]
        );
        return $this->getRender(Template::ADMINCHARSUBSECCBT, $attributesMerged);
    }
    
    private function getSubSectionSkillsBlock(): string
    {
        $skills = SkillEnum::cases();
        $proficiencyBonus = $this->entityHero->getProficiencyBonus();
        
        $strSkills = '';
        while (!empty($skills)) {
            $skill = array_shift($skills);
            $skillLabel = $skill->label();
            $abilityKey = $skill->ability()->value;
            
            $value = $this->entityHero->getAbility($abilityKey);
            $blnProf = true;// A définir dynamiquement selon le personnage...
            // A priori, un bool n'est pas la solution, puisqu'on peut être "standard", "proficient" ou "expert"

            $modAbility = Utils::getModAbility($value) + ($blnProf ? $proficiencyBonus : 0);
            $ariaLabel = Utils::formatStringAbility($modAbility);
            $mod = Utils::formatStringModAbility($modAbility);
        
            $attributesMerged = array_merge(
                $this->defaultColor,
                [
                    $abilityKey,
                    $skillLabel,
                    ($blnProf ? '' : 'Not ').'Proficient',
                    $blnProf ? 'hasProficiency' : '',
                    $ariaLabel,
                    $mod,
                ]
            );
            $strSkills .= $this->getRender(Template::ADMINCHARSUBSECSKL, $attributesMerged);
        }
        
        return $this->getRender(Template::ADMINCHARSUBSECSKLS, array_merge($this->defaultColor, [$strSkills]));
    }
    
    private function getSubSectionAbilitiesBlock(): string
    {
        $proficiencyBonus = $this->entityHero->getProficiencyBonus();
        $abilities = AbilityEnum::cases();
            
        $strAbilities = '';
        while (!empty($abilities)) {
            $ability = array_shift($abilities);

            $label = $ability->label();
            $blnProf = $this->entityHero->hasProficiencyAbility($ability->value);
            // A priori, un bool n'est pas la solution, puisqu'on peut être "standard", "proficient" ou "expert"
            
            $value = $this->entityHero->getAbility($ability->value);
            $modAbility = Utils::getModAbility($value) + ($blnProf ? $proficiencyBonus : 0);
            $ariaLabel = Utils::formatStringAbility($modAbility);
            $mod = Utils::formatStringModAbility($modAbility);
            
            $attributesMerged = array_merge(
                $this->defaultColor,
                [
                    substr(strtoupper($label), 0, 3),
                    $label,
                    ($blnProf ? '' : 'Not ').'Proficient',
                    $blnProf ? 'hasProficiency' : '',
                    $ariaLabel,
                    $mod
                ]
            );
            $strAbilities .= $this->getRender(Template::ADMINCHARSUBSECABY, $attributesMerged);
        }
        
        $attributes = [
            $strAbilities
        ];
        return $this->getRender(Template::ADMINCHARSUBSECABIL, array_merge($this->defaultColor, $attributes));
    }
}
