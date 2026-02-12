<?php
namespace src\Form;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Utils\Html;

class Form
{
    protected string $contentHeader;
    private array $formRows = [];
    private int $nbRows = -1;

    public function addRow(array $attributes=[]): self
    {
        $this->nbRows++;
        $this->formRows[$this->nbRows] = [Constant::CST_ATTRIBUTES=>$attributes, Constant::CST_CONTENT=>''];
        return $this;
    }

    public function addInput(string $id, string $name, string $label, $value, array $extraAttributes=[]): self
    {
        $attributes = $this->initAttributes($id, $name, $label, $value);

        if (isset($extraAttributes[Constant::CST_CLASS])) {
            $attributes[Constant::CST_CLASS] .= ' '.$extraAttributes[Constant::CST_CLASS];
        }
        $attributes[Constant::CST_TYPE] = $extraAttributes[Constant::CST_TYPE] ?? Bootstrap::CSS_TEXT;

        $spanAttributes = [];
        if (isset($extraAttributes[Constant::CST_TYPE]) &&
            $extraAttributes[Constant::CST_TYPE]=='hidden') {
            $spanAttributes[Constant::CST_CLASS] = Bootstrap::CSS_DNONE;
        }

        if ($label!='') {
            $this->formRows[$this->nbRows][Constant::CST_CONTENT] .= $this->getSpan($id, $label, $spanAttributes);
        }
        $this->formRows[$this->nbRows][Constant::CST_CONTENT] .= Html::getBalise('input', '', $attributes);

        return $this;
    }

    public function getFormContent(): string
    {
        $strContent = '';
        while (!empty($this->formRows)) {
            $row = array_shift($this->formRows);
            if (isset($row[Constant::CST_ATTRIBUTES][Constant::CST_CLASS])) {
                $row[Constant::CST_ATTRIBUTES][Constant::CST_CLASS] .= ' input-group mb-3';
            } else {
                $row[Constant::CST_ATTRIBUTES][Constant::CST_CLASS] = ' input-group mb-3';
            }
            $strContent .= Html::getDiv($row[Constant::CST_CONTENT], $row[Constant::CST_ATTRIBUTES]);
        }

        $formBalise = Html::getBalise(
            'form',
            $strContent,//$card->display(),
            ['method'=>'post']
        );

        return Html::getBalise(
            'section',
            $formBalise,
            [Constant::CST_CLASS=>'wrapper pt-3 col-12']
        );
    }

    public function addFiller(array $extraAttributes=[]): self
    {
        $attributes = [
            Constant::CST_CLASS => $extraAttributes[Constant::CST_CLASS] ?? 'col-8',
        ];
        $this->formRows[$this->nbRows][Constant::CST_CONTENT] .= $this->getSpan('', '', $attributes);
        return $this;
    }


    private function getSpan(string $id, string $label, array $extraAttributes=[]): string
    {
        $attributes = [
            Constant::CST_CLASS =>'input-group-text '.($extraAttributes[Constant::CST_CLASS]??Bootstrap::CSS_COL_2),
            'for' => $id,
        ];
        return Html::getSpan($label, $attributes);
    }
    
    private function initAttributes(string $id, string $name, string $label, $value): array
    {
        return [
            Constant::CST_CLASS => 'form-control',
            Constant::CST_NAME => $name,
            Constant::CST_ID => $id,
            Constant::CST_VALUE => $value,
            'aria' => [
                'label' => $label,
                'describedby' => $label,
            ]
        ];
    }
}
