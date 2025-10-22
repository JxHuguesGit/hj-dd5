<?php
namespace src\Form;

use src\Utils\Html;

class Form
{
    protected string $contentHeader;
    private array $formRows = [];
    private int $nbRows = -1;

    public function addRow(array $attributes=[]): self
    {
        $this->nbRows++;
        $this->formRows[$this->nbRows] = ['attributes'=>$attributes, 'content'=>''];
        return $this;
    }

    public function addInput(string $id, string $name, string $label, $value, array $extraAttributes=[]): self
    {
        $attributes = $this->initAttributes($id, $name, $label, $value);

        if (isset($extraAttributes['class'])) {
            $attributes['class'] .= ' '.$attributes['class'];
        }
        $attributes['type'] = $extraAttributes['type'] ?? 'text';

        $spanAttributes = [];
        if (isset($extraAttributes['type']) &&
            $extraAttributes['type']=='hidden') {
            $spanAttributes['class'] = 'd-none';
        }

        if ($label!='') {
            $this->formRows[$this->nbRows]['content'] .= $this->getSpan($id, $label, $spanAttributes);
        }
        $this->formRows[$this->nbRows]['content'] .= Html::getBalise('input', '', $attributes);

        return $this;
    }

    public function getFormContent(): string
    {
        $strContent = '';
        while (!empty($this->formRows)) {
            $row = array_shift($this->formRows);
            if (isset($row['attributes']['class'])) {
                $row['attributes']['class'] .= ' input-group mb-3';
            } else {
                $row['attributes']['class'] = ' input-group mb-3';
            }
            $strContent .= Html::getDiv($row['content'], $row['attributes']);
        }

        $formBalise = Html::getBalise(
            'form',
            $strContent,//$card->display(),
            ['method'=>'post']
        );

        return Html::getBalise(
            'section',
            $formBalise,
            ['class'=>'wrapper pt-3 col-12']
        );
    }

    public function addFiller(array $extraAttributes=[]): self
    {
        $attributes = [
            'class' => $extraAttributes['class'] ?? 'col-8',
        ];
        $this->formRows[$this->nbRows]['content'] .= $this->getSpan('', '', $attributes);
        return $this;
    }


    private function getSpan(string $id, string $label, array $extraAttributes=[]): string
    {
        $attributes = [
            'class' =>'input-group-text '.($extraAttributes['class']??'col-2'),
            'for' => $id,
        ];
        return Html::getSpan($label, $attributes);
    }
    
    private function initAttributes(string $id, string $name, string $label, $value): array
    {
        return [
            'class' => 'form-control',
            'name' => $name,
            'id' => $id,
            'aria-label' => $label,
            'aria-describedby' => $label,
            'value' => $value,
        ];
    }
}
