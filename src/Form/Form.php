<?php
namespace src\Form;

use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Utils\Html;

class Form
{
    protected string $contentHeader;
    private array $formRows = [];
    private int $nbRows     = -1;

    public function addRow(array $attributes = []): self
    {
        $this->nbRows++;
        $this->formRows[$this->nbRows] = [Constant::ATTRIBUTES => $attributes, Constant::CONTENT => ''];
        return $this;
    }

    public function addInput(string $id, string $name, string $label, $value, array $extraAttributes = []): self
    {
        $attributes = $this->initAttributes($id, $name, $label, $value);

        if (isset($extraAttributes[Constant::CSSCLASS])) {
            $attributes[Constant::CSSCLASS] .= ' ' . $extraAttributes[Constant::CSSCLASS];
        }
        $attributes[Constant::TYPE] = $extraAttributes[Constant::TYPE] ?? B::TEXT;

        $spanAttributes = [];
        if (isset($extraAttributes[Constant::TYPE]) &&
            $extraAttributes[Constant::TYPE] == 'hidden') {
            $spanAttributes[Constant::CSSCLASS] = B::DNONE;
        }

        if ($label != '') {
            $this->formRows[$this->nbRows][Constant::CONTENT] .= $this->getSpan($id, $label, $spanAttributes);
        }
        $this->formRows[$this->nbRows][Constant::CONTENT] .= Html::getBalise('input', '', $attributes);

        return $this;
    }

    public function getFormContent(): string
    {
        $strContent = '';
        while (! empty($this->formRows)) {
            $row = array_shift($this->formRows);
            if (isset($row[Constant::ATTRIBUTES][Constant::CSSCLASS])) {
                $row[Constant::ATTRIBUTES][Constant::CSSCLASS] .= ' input-group mb-3';
            } else {
                $row[Constant::ATTRIBUTES][Constant::CSSCLASS] = ' input-group mb-3';
            }
            $strContent .= Html::getDiv($row[Constant::CONTENT], $row[Constant::ATTRIBUTES]);
        }

        $formBalise  = Html::getBalise(
            'form',
            $strContent, //$card->display(),
            ['method' => 'post']
        );

        return Html::getBalise(
            'section',
            $formBalise,
            [Constant::CSSCLASS => 'wrapper pt-3 col-12']
        );
    }

    public function addFiller(array $extraAttributes = []): self
    {
        $attributes  = [
            Constant::CSSCLASS => $extraAttributes[Constant::CSSCLASS] ?? 'col-8',
        ];
        $this->formRows[$this->nbRows][Constant::CONTENT] .= $this->getSpan('', '', $attributes);
        return $this;
    }

    private function getSpan(string $id, string $label, array $extraAttributes = []): string
    {
        $attributes = [
            Constant::CSSCLASS => 'input-group-text ' . ($extraAttributes[Constant::CSSCLASS] ?? B::COL_2),
            'for'               => $id,
        ];
        return Html::getSpan($label, $attributes);
    }

    private function initAttributes(string $id, string $name, string $label, $value): array
    {
        return [
            Constant::CSSCLASS => 'form-control',
            Constant::NAME  => $name,
            Constant::ID    => $id,
            Constant::VALUE => $value,
            'aria'              => [
                'label'       => $label,
                'describedby' => $label,
            ],
        ];
    }
}
