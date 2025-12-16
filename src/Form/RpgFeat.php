<?php
namespace src\Form;

use src\Constant\Field;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Entity\RpgFeat as EntityRpgFeat;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Session;

class RpgFeat extends Form
{
    public EntityRpgFeat $rpgFeat;

    public function __construct(EntityRpgFeat $rpgFeat)
    {
        $this->rpgFeat = $rpgFeat;
    }

    public function resolveForm(): void
    {
        $monsterId = Session::fromPost('entityId');
        $name = Session::fromPost('name-fr');
        
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $dao = new RepositoryRpgMonster($queryBuilder, $queryExecutor);
        $obj = $dao->find($monsterId);

        $obj->setField(Field::FRNAME, $name);
        $dao->update($obj);

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
    }
    
    public function getTemplate(): string
    {
        $controller = new Utilities();
        
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
    }
}
