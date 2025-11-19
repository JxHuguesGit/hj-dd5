<?php
namespace src\Form;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Entity\RpgFeat as EntityRpgFeat;
use src\Repository\RpgFeat as RepositoryRpgFeat;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Html;
use src\Utils\Session;

class SpellFilter extends Form
{
    public EntityRpgFeat $rpgFeat;

    public function __construct(EntityRpgFeat $rpgFeat)
    {
        $this->rpgFeat = $rpgFeat;
    }

    public function resolveForm(): void
    {
    return;
    /*
        $monsterId = Session::fromPost('entityId');
        $name = Session::fromPost('name-fr');
        
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $dao = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        $obj = $dao->find($monsterId);

        $obj->setField(Field::FRNAME, $name);
        $dao->update($obj);


        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $dao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);

        $params = Session::getPost();
        foreach ($params as $key => $value) {
            if (substr($key, 0, 9)!=='mab-rank-') {
                continue;
            }
            
            list(, , $monsterAbilityId) = explode('-', $key);
            $obj = $dao->find($monsterAbilityId);
            
            $name = $params['mab-name-'.$monsterAbilityId];
            $description = $params['mab-description-'.$monsterAbilityId];
            $rank = $params['mab-rank-'.$monsterAbilityId];
            
            $obj->setField(Field::NAME, $name)
                ->setField(Field::DESCRIPTION, $description)
                ->setField(Field::RANK, $rank);

            if ($rank==0) {
                $dao->delete($obj);
            } else {
                $dao->update($obj);
            }
        }
            */
    }
    
    public function getTemplate(): string
    {
        $controller = new Utilities();
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        
        $url = '/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=compendium&id=feats';
        if (Session::fromGet('curpage', 1)!=1) {
            $url = add_query_arg('curpage', Session::fromGet('curpage'), $url);
        }
        if (Session::fromGet('nbPerPage', 10)!=10) {
            $url = add_query_arg('nbPerPage', Session::fromGet('nbPerPage'), $url);
        }
        
        $attributes = [
            '',
            '',
            '',
            '',
            $url,
            '', '', '', '', ''];
        
        return $controller->getRender(Template::FORM_FEAT, $attributes);
        /*
        $dao = new RepositoryRpgMonsterAbility($queryBuilder, $queryExecutor);
        $objs = $dao->findBy([Field::MONSTERID=>$this->rpgMonster->getField(Field::ID)]);
        
        $strMonsterAbilities = '';
        $cpt = 0;
        $objs->rewind();
        while ($objs->valid()) {
            $obj = $objs->current();

            $strMonsterAbilities .= $this->getMonsterAbilityForm($obj);
            ++$cpt;

            $objs->next();
        }
        
        $attributes = [
            $this->rpgMonster->getField(Field::FRNAME),
            $this->rpgMonster->getField(Field::NAME),
            $strMonsterAbilities,
            $this->rpgMonster->getField(Field::ID),
            $url
        ];
        */

    }
    
    /*
    private function getMonsterAbilityForm(EntityRpgMonsterAbility $rpgMonsterAbility): string
    {
        $cpt = $rpgMonsterAbility->getField(Field::ID);
        return '<div class="input-group">
              <span class="input-group-text">Nom</span>
              <input type="text" class="form-control" id="mab-name-'.$cpt.'" name="mab-name-'.$cpt.'" value="'.stripslashes($rpgMonsterAbility->getField(Field::NAME)).'" data-action="RmbFocus">
              <span class="input-group-text">Rang</span>
              <input type="number" class="form-control col-2" id="mab-rank-'.$cpt.'" name="mab-rank-'.$cpt.'" value="'.max(1, $rpgMonsterAbility->getField(Field::RANK)).'" data-action="RmbFocus">
            </div>
            <div class="input-group mb-3">
              <textarea class="form-control" id="mab-description-'.$cpt.'" name="mab-description-'.$cpt.'" data-action="RmbFocus">'.stripslashes($rpgMonsterAbility->getField(Field::DESCRIPTION)).'</textarea>
            </div>';    
    }
            */
}