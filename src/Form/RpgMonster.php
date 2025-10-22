<?php
namespace src\Form;

use src\Constant\Constant;
use src\Constant\Field;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Utils\Html;

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

        /*
        $this->addInput(Field::LOGNAME, Field::LOGNAME, LabelConstant::LBL_ID, $this->player->getField(Field::LOGNAME));
        $this->addInput(Field::PASSWORD, Field::PASSWORD, LabelConstant::LBL_MDP, $this->player->getField(Field::PASSWORD));
        */
        
        /*
    <div class="mb-3">
      <label for="name-fr" class="form-label">Nom (FR) <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="name-fr" name="name-fr" required>
    </div>
        */

        // Lastname, firstname et surname
        $this->addRow();
        /*
        $this->addInput(FieldConstant::LASTNAME, FieldConstant::LASTNAME, LabelConstant::LBL_NAME, $this->player->getField(FieldConstant::LASTNAME));
        $this->addInput(FieldConstant::FIRSTNAME, FieldConstant::FIRSTNAME, LabelConstant::LBL_FIRSTNAME, $this->player->getField(FieldConstant::FIRSTNAME));
        $this->addInput(FieldConstant::SURNAME, FieldConstant::SURNAME, LabelConstant::LBL_SURNAME, $this->player->getField(FieldConstant::SURNAME));
        */

        // Serialnumber, startDate, endDate
        $this->addRow();
        /*
        $this->addInput(FieldConstant::SERIALNUMBER, FieldConstant::SERIALNUMBER, LabelConstant::LBL_MATRICULE, $this->player->getField(FieldConstant::SERIALNUMBER));
        $this->addInput(FieldConstant::STARTDATE, FieldConstant::STARTDATE, LabelConstant::LBL_INTEGRATION_DATE, $this->player->getField(FieldConstant::STARTDATE), [ConstantConstant::CST_TYPE=>'date']);
        $this->addInput(FieldConstant::ENDDATE, FieldConstant::ENDDATE, LabelConstant::LBL_END_SHIFT_DATE, $this->player->getField(FieldConstant::ENDDATE), [ConstantConstant::CST_TYPE=>'date']);
        */

        // Grade, échelon, section
        $this->addRow();
        /*
        $this->addSelect(FieldConstant::RANK, FieldConstant::RANK, LabelConstant::LBL_GRADE, RankEnum::cases(), $this->player->getField(FieldConstant::RANK));
        $this->addInput(FieldConstant::RANKECHELON, FieldConstant::RANKECHELON, LabelConstant::LBL_ECHELON, $this->player->getField(FieldConstant::RANKECHELON));
        $this->addSelect(FieldConstant::SECTION, FieldConstant::SECTION, LabelConstant::LBL_SECTION, SectionEnum::cases(), $this->player->getField(FieldConstant::SECTION));
        */

        $this->addRow();
        /*
        $this->addHidden(ConstantConstant::CST_FORMNAME, ConstantConstant::CST_FORMNAME, 'copsPlayer');
        */
    }

    public function getFormContent(): string
    {
        $formContent = parent::getFormContent();
        $btnSubmit = Html::getButton('Soumettre', ['type'=>'submit']);
/*
        $card = new CardUtils(['style'=>'max-width:initial']);
        $card->addClass('p-0')
            ->setHeader(['content'=>'Informations Cops'])
            ->setBody(['content'=>$formContent])
            ->setFooter(['content'=>$btnSubmit]);
*/
        return Html::getBalise(
            'form',
            $formContent,//$card->display(),
            [
                'method'=>'post',
                'class'=>'col-12'
            ]
        );
    }
/*
    public function controlForm(): void
    {
        // Donc on a un _POST qui vient d'être soumis. On vérifie les différents champs et leurs valeurs.
        // En cas d'erreur, on rajoute des flags d'erreur.
        $blnErrors = false;
        // Si aucune erreur, on met à jour les données en base et on les utilise pour l'affichage.
        $blnUpdate = false;

        // Les champs modifiables pour le moment
        // rank
        $postRank = SessionUtils::fromPost(FieldConstant::RANK);
        if ($this->player->getField(FieldConstant::RANK)!=$postRank) {
            $blnUpdate = true;
            $this->player->setField(FieldConstant::RANK, $postRank);
        }
        // rankEchelon
        $postRankEchelon = SessionUtils::fromPost(FieldConstant::RANKECHELON);
        if ($this->player->getField(FieldConstant::RANKECHELON)!=$postRankEchelon) {
            $blnUpdate = true;
            $this->player->setField(FieldConstant::RANKECHELON, $postRankEchelon);
        }
        // section
        $postSection = SessionUtils::fromPost(FieldConstant::SECTION);
        if ($this->player->getField(FieldConstant::SECTION)!=$postSection) {
            $blnUpdate = true;
            $this->player->setField(FieldConstant::SECTION, $postSection);
        }
        // startDate
        $postStartDate = SessionUtils::fromPost(FieldConstant::STARTDATE);
        if ($this->player->getField(FieldConstant::STARTDATE)!=$postStartDate) {
            $blnUpdate = true;
            $this->player->setField(FieldConstant::STARTDATE, $postStartDate);
        }
        // endDate
        $postEndDate = SessionUtils::fromPost(FieldConstant::ENDDATE);
        if ($this->player->getField(FieldConstant::ENDDATE)!=$postEndDate) {
            $blnUpdate = true;
            $this->player->setField(FieldConstant::ENDDATE, $postEndDate);
        }

        if ($blnUpdate && !$blnErrors) {
            $this->player->update();
        }
    }
    */
}
