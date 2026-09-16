<?php
namespace src\Presenter\FormBuilder;

use src\Service\Reader\OriginReader;
use src\Service\Reader\PreRequisReader;
use src\Utils\Form;

class FeatFilterFormBuilder extends AbstractFormBuilder implements FormBuilderInterface
{
    public function __construct(
        private PreRequisReader $preRequisReader,
        private OriginReader $originReader
    ) {}

    public function build(object $entity, array $params = []): Form
    {
        $form = $this->createForm($params);
        $fieldset = new FieldsetField('');

        var_dump($this->preRequisReader);
        var_dump($this->originReader);

        $form->addField($fieldset);
        return $form;
/*
    $prerequisites = $this->preRequisReader->allPreRequis();
        $sources       = $this->originReader->allOrigins();

        ob_start();
        ?>
        <div class="feat-filters">
            <label for="filter-feat-name">Nom</label>
            <input
                type="text"
                id="filter-feat-name"
                placeholder="Rechercher un don"
            >

            <label for="filter-prerequisite">Prérequis</label>
            <select id="filter-prerequisite">
                <option value="">Tous les prérequis</option>

                <?php foreach ($prerequisites as $prerequisite): ?>
                    <option value="<?= $prerequisite->id ?>">
                        <?= htmlspecialchars($prerequisite->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="filter-source">Source</label>
            <select id="filter-source">
                <option value="">Toutes les sources</option>

                <?php foreach ($sources as $source): ?>
                    <option value="<?= $source->id ?>">
                        <?= htmlspecialchars($source->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php

        return ob_get_clean();
        */
    }
}
