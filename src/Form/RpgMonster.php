<?php
namespace src\Form;

use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Controller\Utilities;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgMonsterAbility as RepositoryRpgMonsterAbility;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Utils\Html;
use src\Utils\Session;

class RpgMonster extends Form
{
    public EntityRpgMonster $rpgMonster;

    public function __construct(EntityRpgMonster $rpgMonster)
    {
        $this->rpgMonster = $rpgMonster;
    }

    public function buildForm(): void
    {
        // Nom français + Nom anglais
        $this->addRow()
            ->addInput(Field::FRNAME, Field::FRNAME, 'Nom français', $this->rpgMonster->getField(Field::FRNAME))
            ->addFiller(['class'=>'col-2'])
            ->addInput(Field::NAME, Field::NAME, 'Nom anglais', $this->rpgMonster->getField(Field::NAME));

        // CA et remarques + Initiative
        $this->addRow()
            ->addInput(Field::SCORECA, Field::SCORECA, 'CA', $this->rpgMonster->getField(Field::SCORECA))
            ->addFiller(['class'=>'col-1'])
            ->addInput(Field::SCORECA.Constant::CST_EXTRA, Field::SCORECA.Constant::CST_EXTRA, '', $this->rpgMonster->getExtra(Field::SCORECA), ['class'=>'col-3'])
            ->addFiller(['class'=>'col-1'])
            ->addInput(Field::INITIATIVE, Field::INITIATIVE, 'Initiative', $this->rpgMonster->getField(Field::INITIATIVE));

        // PV et remarques
        $this->addRow()
            ->addInput(Field::SCOREHP, Field::SCOREHP, 'PV', $this->rpgMonster->getField(Field::SCOREHP))
            ->addFiller(['class'=>'col-1'])
            ->addInput(Field::SCOREHP.Constant::CST_EXTRA, Field::SCOREHP.Constant::CST_EXTRA, '', $this->rpgMonster->getExtra(Field::SCOREHP), ['class'=>'col-5'])
            ->addFiller(['class'=>'col-3']);

        // Vitesses
        $this->addRow()
            ->addInput(Field::VITESSE, Field::VITESSE, 'Vitesse au sol', $this->rpgMonster->getField(Field::VITESSE))
            ->addFiller(['class'=>'col-1']);
    }

    public function getFormContent(): string
    {
        $formContent = parent::getFormContent();

        return Html::getBalise(
            'form',
            $formContent,
            [
                'method'=>'post',
                'class'=>'col-12'
            ]
        );
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
            $dao->update($obj);
        }
    }
    
    public function getTemplate(): string
    {
	    $controller = new Utilities();
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
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
        
        $url = '/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=compendium&id=monsters';
        if (Session::fromGet('curpage', 1)!=1) {
	        $url = add_query_arg('curpage', Session::fromGet('curpage'), $url);
        }
        if (Session::fromGet('nbPerPage', 10)!=10) {
	        $url = add_query_arg('nbPerPage', Session::fromGet('nbPerPage'), $url);
        }
        $attributes = [
        	$this->rpgMonster->getField(Field::FRNAME),
        	$this->rpgMonster->getField(Field::NAME),
            $strMonsterAbilities,
        	$this->rpgMonster->getField(Field::ID),
            $url
        ];

        $content = $controller->getRender(Template::FORM_MONSTERABILITY, $attributes);
        return $content;
    }
    
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
}
