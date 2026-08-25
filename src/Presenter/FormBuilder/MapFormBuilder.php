<?php

namespace src\Presenter\FormBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Domain\Entity\Map;
use src\Utils\Form;

final class MapFormBuilder extends AbstractFormBuilder
{
    /**
     * @param Map $map
     */
    public function build(object $map, array $params = []): Form
    {
        $form = $this->createForm($params);

        $form
            ->addField(new TextField(
                'name',
                'Nom',
                $map->name
            ))
            ->addField(new TextField(
                'image',
                'Image',
                $map->image
            ))
            ->addField(new NumberField(
                'mapColumns',
                'Nombre de colonnes',
                $map->mapColumns,
                false,
                [
                    C::OUTERDIVCLASS => B::COL_6,
                    'step' => 1,
                ]
            ))
            ->addField(new NumberField(
                'mapRows',
                'Nombre de lignes',
                $map->mapRows,
                false,
                [
                    C::OUTERDIVCLASS => B::COL_6,
                    'step' => 1,
                ]
            ))
            ->addField(new NumberField(
                'cellSize',
                'Taille des cellules',
                $map->cellSize,
                false,
                [
                    C::OUTERDIVCLASS => B::COL_6,
                    'step' => 1,
                ]
            ))
            ->addField(new NumberField(
                'visionRange',
                'Vision Range',
                $map->visionRange,
                false,
                [
                    C::OUTERDIVCLASS => B::COL_6,
                    'step' => 1,
                ]
            ));

        return $form;
    }
}
