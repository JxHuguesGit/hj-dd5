<?php
namespace src\Form;
/*
use src\Constant\IconConstant;
use src\Constant\LabelConstant;
use src\Controller\UtilitiesController;
use src\Utils\CardUtils;
use src\Utils\SessionUtils;
*/
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
		/*
        if (isset($extraAttributes[ConstantConstant::CST_READONLY])) {
            $attributes[ConstantConstant::CST_READONLY] = ConstantConstant::CST_READONLY;
        }
        if (isset($extraAttributes['required'])) {
            $attributes['required'] = 'required';
        }
        */

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

        $btnSubmit = Html::getButton('Soumettre', ['type'=>'submit']);
/*
        $card = new CardUtils([ConstantConstant::CST_STYLE=>'max-width:initial']);
        $card->addClass('p-0')
            ->setHeader([ConstantConstant::CST_CONTENT=>$this->contentHeader])
            ->setBody([ConstantConstant::CST_CONTENT=>$strContent])
            ->setFooter([ConstantConstant::CST_CONTENT=>$btnSubmit]);
*/
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
    
/*

    public function setContentHeader(string $contentHeader): self
    {
        $this->contentHeader = $contentHeader;
        return $this;
    }

    public function setContentRow(string $content): self
    {
        if (!empty($this->formRows[$this->nbRows]['content'])) {
            $this->formRows[$this->nbRows]['content'] .= $content;
        } else {
            $this->formRows[$this->nbRows]  = ['content'=>$content];
        }
        return $this;
    }



    public function addBtnDelete(string $href, array $extraAttributes=[]): void
    {
        $icon = HtmlUtils::getIcon(IconConstant::I_TRASHALT);
        $link = HtmlUtils::getLink($icon, $href, 'text-white');
        $btn = HtmlUtils::getButton($link);
        $attributes = [
            ConstantConstant::CST_CLASS => $extraAttributes[ConstantConstant::CST_CLASS] ?? 'col-8',
        ];
        $this->formRows[$this->nbRows]['content'] .= $this->getSpan('', $btn, $attributes);
    }


    public function addFileInput(string $id, string $label, $value, array $extraAttributes=[]): void
    {
        $extraAttributes[ConstantConstant::CST_TYPE] = ConstantConstant::CST_FILE;
        $this->addInput($id, $id, $label, $value, $extraAttributes);
    }

    public function addTextarea(string $id, string $label, $value, array $extraAttributes=[]): self
    {
        $attributes = $this->initAttributes($id, $id, $label, $value);
        $attributes['rows'] = $extraAttributes['rows'] ?? '5';

        $this->formRows[$this->nbRows]['content'] .= $this->getSpan($id, $label).HtmlUtils::getTextarea($value, $attributes);
        return $this;
    }

    public function addSelect(string $id, string $name, string $label, array $enumCases, $value): self
    {
        $content = HtmlUtils::getBalise('option', 'Choisir une valeur', [ConstantConstant::CST_VALUE=>-1]);

        while (!empty($enumCases)) {
            $element = array_shift($enumCases);
            if (is_array($element)) {
                $elementValue = $element[ConstantConstant::CST_VALUE];
                $elementLabel = $element[ConstantConstant::CST_LABEL];
            } else {
                $elementValue = $element->value;
                $elementLabel = $element->label();
            }
            $optAttributes = [ConstantConstant::CST_VALUE=>$elementValue];
            if ($elementValue==$value) {
                $optAttributes[ConstantConstant::CST_SELECTED] = ConstantConstant::CST_SELECTED;
            }
            $content .= HtmlUtils::getBalise('option', $elementLabel, $optAttributes);
        }

        $attributes = $this->initAttributes($id, $name, $label, $value);
        unset($attributes[ConstantConstant::CST_VALUE]);
        $strSelect = HtmlUtils::getBalise('select', $content, $attributes);

        $this->formRows[$this->nbRows]['content'] .= $this->getSpan($id, $label).$strSelect;

        return $this;
    }

    // TODO : removed attribute - , array $extraAttributes=[]
    // Check why it was there and why it isn't needed anymore
    public function addDataList(string $id, string $label, array $collection, $value): void
    {
        $this->formRows[$this->nbRows]['content'] .= $this->getSpan($id, $label);

        $attributes = $this->initAttributes($id, $id, $label, $value);
        $attributes['list'] = 'datalistOptions'.$id;

        $this->formRows[$this->nbRows] .= HtmlUtils::getBalise('input', '', $attributes);

        $dataListContent = '';
        while (!empty($collection)) {
            $element = array_shift($collection);
            $dataListContent .= HtmlUtils::getBalise('option', '', [ConstantConstant::CST_VALUE=>$element]);
        }
        $this->formRows[$this->nbRows]['content'] .= HtmlUtils::getBalise(
            'datalist',
            $dataListContent,
            [ConstantConstant::CST_ID=>'datalistOptions'.$id]
        );
    }

    public function addHidden(string $id, string $name, $value, array $extraAttributes=[]): self
    {
        $attributes = $this->initAttributes($id, $name, '', $value);

        if (isset($extraAttributes[ConstantConstant::CST_CLASS])) {
            $attributes[ConstantConstant::CST_CLASS] .= ' '.$attributes[ConstantConstant::CST_CLASS];
        }
        $attributes[ConstantConstant::CST_TYPE] = 'hidden';

        $this->formRows[$this->nbRows]['content'] .= HtmlUtils::getBalise('input', '', $attributes);

        return $this;
    }



    public function addBreak(): self
    {
        $this->formRows[$this->nbRows]['content'] .= '<div class="col-12">&nbsp;</div>';
        return $this;
    }

    public function addTabs(array $tabs, string $defaultTab): self
    {
        $strUlContent = '';
        $activeTab = SessionUtils::fromGet(ConstantConstant::CST_ACTIVE_TAB, $defaultTab);
        
        foreach ($tabs as $key => $value) {
            $strLink = HtmlUtils::getLink($value, '#'.$key, 'nav-link'.($key==$activeTab ? ' active' : ''), ['role'=>'tab']);
            $strUlContent .= HtmlUtils::getLi($strLink, [ConstantConstant::CST_CLASS=>'nav-item']);
        }
        $this->formRows[$this->nbRows]['content'] = HtmlUtils::getBalise('ul', $strUlContent, [ConstantConstant::CST_CLASS=>'nav nav-tabs w-100']);
        return $this;
    }
*/
}