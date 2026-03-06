<?php
namespace src\Presenter\FormBuilder;

use src\Constant\Constant as C;
use src\Utils\Html;

class SelectField extends FormField
{
    private array $options;

    public function __construct(
        string $name,
        string $label,
        mixed $value = null,
        array $options = [],
        protected array $params = [],
    ) {
        parent::__construct($name, $label, $value, false, $params);
        $this->options = $options;
    }

    public function getOptions(): array
    {return $this->options;}

    public function renderInput(): string
    {
        $strOptions = '';
        foreach ($this->options as $option) {
            $strOptions .= Html::getOption(
                $option[C::LABEL],
                [C::VALUE => $option[C::VALUE]],
                $this->value == $option[C::VALUE]
            );
        }
        $attrs = [
            C::ID    => $this->getId(),
            C::NAME  => $this->name,
            C::CSSCLASS => 'form-select',
        ];
        if ($this->readonly) {
            $attrs['readonly'] = 'readonly';
        }

        return Html::getBalise('select', $strOptions, $attrs);
    }
}
