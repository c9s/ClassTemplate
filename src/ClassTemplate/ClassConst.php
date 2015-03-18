<?php
namespace ClassTemplate;
use ClassTemplate\Utils;
use ClassTemplate\Renderable;
use ClassTemplate\Indenter;

class ClassConst extends Statement implements Renderable
{
    public $name;

    public $value;

    public function __construct($name,$value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function render(array $args = array()) {
        return Indenter::indent($this->indentLevel) . 'const ' . $this->name . ' = ' . var_export($this->value,true) . ';';
    }

    public function __toString() {
        return $this->render();
    }
    
}

