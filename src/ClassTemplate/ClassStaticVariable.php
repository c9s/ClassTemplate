<?php
namespace ClassTemplate;

class ClassStaticVariable extends ClassProperty
{
    public function render()
    {
        return $this->scope . ' static $' . $this->name . ' = ' . var_export($this->value,true) . ';';
    }
}

