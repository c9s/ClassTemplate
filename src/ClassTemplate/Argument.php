<?php
namespace ClassTemplate;
use ClassTemplate\Renderable;

class Argument implements Renderable
{
    public $name;

    public $default;

    public function __construct($name, $default = NULL) {
        $this->name = $name;
        $this->default = $default;
    }

    public function render(array $args = array()) {
        $code = $this->name;
        if ($this->default) {
            $code .= var_export($this->default, true);
        }
        return $code;
    }

}




