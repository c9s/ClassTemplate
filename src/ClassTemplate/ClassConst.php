<?php
namespace ClassTemplate;
use ClassTemplate\Utils;

class ClassConst extends Statement
{
    public $name;

    public $value;

    public function __construct($name,$value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function render() {
        return Utils::indent(1) . 'const ' . $this->name . ' = ' . var_export($this->value,true) . ';';
    }
}

