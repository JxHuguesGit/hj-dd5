<?php
namespace src\Presenter\FormBuilder;

use src\Utils\Form;

interface FormBuilderInterface
{
    public function build(object $entity, array $params = []): Form;
}
