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
}
