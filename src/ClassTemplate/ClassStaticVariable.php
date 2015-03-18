<?php
namespace ClassTemplate;
use ClassTemplate\Renderable;

class ClassStaticVariable extends ClassProperty implements Renderable
{
    public function render(array $args = array())
    {
        return $this->scope . ' static $' . $this->name . ' = ' . var_export($this->value,true) . ';';
    }

    public function __toString() {
        return $this->render();
    }
}

