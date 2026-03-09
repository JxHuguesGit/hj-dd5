<?php
namespace src\Constant;

class Field
{
    public const ID = 'id';

    public const ABBR        = 'abbr';
    public const ARMORCLASS  = 'armorClass';
    public const SCORECA     = 'ca';
    public const CHASCORE    = 'chaScore';
    public const CONSCORE    = 'conScore';
    public const SCORECR     = 'cr';
    public const CREATESTEP  = 'createStep';
    public const DESCRIPTION = 'description';
    public const DEXSCORE    = 'dexScore';
    public const DICECOUNT   = 'diceCount';
    public const DICEFACES   = 'diceFaces';
    public const DONNEES     = 'donnees';
    public const ENTITYTYPE  = 'entityType';
    public const EXPERTISE   = 'expertise';
    public const EXTRA       = 'extra';
    public const FRNAME      = 'frName';
    public const FRTAG       = 'frTag';
    public const GOLDPRICE   = 'goldPrice';
    public const HABITAT     = 'habitat';
    public const SCOREHP     = 'hp';
    public const INCOMPLET   = 'incomplet';
    public const INITIATIVE  = 'initiative';
    public const INTSCORE    = 'intScore';
    public const LASTUPDATE  = 'lastUpdate';
    public const LEGENDARY   = 'legendary';
    public const MAXRANGE    = 'maxRange';
    public const MINRANGE    = 'minRange';
    public const MSTSIZE     = 'monsterSize';
    public const NAME        = 'name';
    public const NIVEAU      = 'niveau';
    public const PERCPASSIVE = 'percPassive';
    public const PROFBONUS   = 'profBonus';
    public const QUANTITY    = 'quantity';
    public const RANK        = 'rank';
    public const SKILLS      = 'skills';
    public const SLUG        = 'slug';
    public const STHDISADV   = 'stealthDisadvantage';
    public const STRPENALTY  = 'strengthPenalty';
    public const STRSCORE    = 'strScore';
    public const SWARMSIZE   = 'swarmSize';
    public const TYPE        = 'type';
    public const UKTAG       = 'ukTag';
    public const VALUE       = 'value';
    public const VITESSE     = 'vitesse';
    public const WEIGHT      = 'weight';
    public const WISSCORE    = 'wisScore';

    /* Champs existants sans nommage
    public const  = 'abilityId1';
    public const  = 'abilityId2';
    public const  = 'abilityId3';
    public const  = 'bonusDex';
    public const  = 'caracEnums';
    public const  = 'skillId1';
    public const  = 'skillId2';
    */

    /* Nommages sans champs existants */
    public const CLASSES = 'classes'; // Est utilisé pour stocker une liste de classes lors d'une sélection dans un formulaire.
    public const SCOREPB = 'pb';      // Permet de récupérer une donnée stockée dans le json.
    public const SCOREXP = 'xp';      // Permet de récupérer une donnée stockée dans le json.
    public const SCHOOL  = 'ecole';   // Champ ACF de Wordpress

    /* Alias dans le code php */
    public const AMMONAME      = 'ammunitionName';
    public const CATEGORYSLUG  = 'categorySlug';
    public const CATEGORYNAME  = 'categoryName';
    public const MASTERYNAME   = 'masteryName';
    public const MASTERYPOSTID = 'masteryPostId';
    public const PROPERTYNAME  = 'propertyName';
    public const PROPERTYSLUG  = 'propertySlug';
    public const RANGENAME     = 'rangeName';
    public const RANGESLUG     = 'rangeSlug';
    public const REFNAME       = 'referenceName';
    public const TYPDMGNAME    = 'typeDamageName';
    public const TYPMSTNAME    = 'typeMonsterName';
    public const SSTYPMSTNAME  = 'subTypeMonsterName';
    public const PARENTNAME    = 'parentName';

    /* Clefs étrangères */
    // rpgFeatAbility, rpgOriginAbility, rpgSkill
    public const ABILITYID    = 'abilityId';
    // rpgMonster
    public const ALGNID       = 'alignmentId';
    // rpgArmor
    public const ARMORTYPID   = 'armorTypeId';
    public const CHARACTERID  = 'characterId';
    public const CLASSEID     = 'classeId';
    public const CONDITIONID  = 'conditionId';
    public const DMGDIEID     = 'damageDieId';
    public const ENTITYID     = 'entityId';
    public const FEATID       = 'featId';
    public const FEATTYPEID   = 'featTypeId';
    public const HEROSID      = 'herosId';
    public const ITEMID       = 'itemId';
    public const LANGUAGEID   = 'languageId';
    public const MSTPROFID    = 'masteryProficiencyId';
    public const MONSTERID    = 'monsterId';
    public const MSTSSTYPID   = 'monsterSubTypeId';
    public const MSTTYPEID    = 'monstreTypeId';
    public const OPTIONID     = 'optionId';
    public const ORIGINID     = 'originId';
    public const PARENTID     = 'parentId';
    public const POSTID       = 'postId';
    public const POWERID      = 'powerId';
    public const REFID        = 'referenceId';
    public const SKILLID      = 'skillId';
    public const SPECIESID    = 'speciesId';
    public const TOOLID       = 'toolId';
    public const TYPEAMMID    = 'typeAmmunitionId';
    public const TYPEDMGID    = 'typeDamageId';
    public const TYPEID       = 'typeId';
    public const TYPERESID    = 'typeResistanceId';
    public const TYPESPEEDID  = 'typeSpeedId';
    public const TYPEVISIONID = 'typeVisionId';
    public const WPNCATID     = 'weaponCategoryId';
    public const WEAPONID     = 'weaponId';
    public const WPNPROPID    = 'weaponPropertyId';
    public const WPNRANGEID   = 'weaponRangeId';
    public const WPUSERID     = 'wpUserId';

    // Existantes, non déclarées
    /*
    public const  = 'packageId';
    */

}
