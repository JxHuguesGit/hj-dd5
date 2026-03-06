<?php
namespace src\Form;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Utils\Html;

class Form
{
    protected string $contentHeader;
    private array $formRows = [];
    private int $nbRows     = -1;

    public function addRow(array $attributes = []): self
    {
        $this->nbRows++;
        $this->formRows[$this->nbRows] = [C::ATTRIBUTES => $attributes, C::CONTENT => ''];
        return $this;
    }

    public function addInput(string $id, string $name, string $label, $value, array $extraAttributes = []): self
    {
        $attributes = $this->initAttributes($id, $name, $label, $value);

        if (isset($extraAttributes[C::CSSCLASS])) {
            $attributes[C::CSSCLASS] .= ' ' . $extraAttributes[C::CSSCLASS];
        }
        $attributes[C::TYPE] = $extraAttributes[C::TYPE] ?? B::TEXT;

        $spanAttributes = [];
        if (isset($extraAttributes[C::TYPE]) &&
            $extraAttributes[C::TYPE] == 'hidden') {
            $spanAttributes[C::CSSCLASS] = B::DNONE;
        }

        if ($label != '') {
            $this->formRows[$this->nbRows][C::CONTENT] .= $this->getSpan($id, $label, $spanAttributes);
        }
        $this->formRows[$this->nbRows][C::CONTENT] .= Html::getBalise('input', '', $attributes);

        return $this;
    }

    public function getFormContent(): string
    {
        $strContent = '';
        while (! empty($this->formRows)) {
            $row = array_shift($this->formRows);
            if (isset($row[C::ATTRIBUTES][C::CSSCLASS])) {
                $row[C::ATTRIBUTES][C::CSSCLASS] .= ' input-group mb-3';
            } else {
                $row[C::ATTRIBUTES][C::CSSCLASS] = ' input-group mb-3';
            }
            $strContent .= Html::getDiv($row[C::CONTENT], $row[C::ATTRIBUTES]);
        }

        $formBalise  = Html::getBalise(
            'form',
            $strContent, //$card->display(),
            ['method' => 'post']
        );

        return Html::getBalise(
            'section',
            $formBalise,
            [C::CSSCLASS => 'wrapper pt-3 col-12']
        );
    }

    public function addFiller(array $extraAttributes = []): self
    {
        $attributes  = [
            C::CSSCLASS => $extraAttributes[C::CSSCLASS] ?? 'col-8',
        ];
        $this->formRows[$this->nbRows][C::CONTENT] .= $this->getSpan('', '', $attributes);
        return $this;
    }

    private function getSpan(string $id, string $label, array $extraAttributes = []): string
    {
        $attributes = [
            C::CSSCLASS => 'input-group-text ' . ($extraAttributes[C::CSSCLASS] ?? B::COL_2),
            'for'               => $id,
        ];
        return Html::getSpan($label, $attributes);
    }

    private function initAttributes(string $id, string $name, string $label, $value): array
    {
        return [
            C::CSSCLASS => 'form-control',
            C::NAME  => $name,
            C::ID    => $id,
            C::VALUE => $value,
            'aria'              => [
                'label'       => $label,
                'describedby' => $label,
            ],
        ];
    }
}
