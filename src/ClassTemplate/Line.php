<?php
namespace ClassTemplate;
use ClassTemplate\Renderable;

abstract class Line {

    public $indentLevel = 0;

    public function setIndentLevel($level) {
        $this->indentLevel = $level;
    }

    public function increaseIndentLevel() {
        $this->indentLevel++;
    }

    public function decreaseIndentLevel() {
        $this->indentLevel--;
    }

    public function __toString()
    {
        return $this->render();
    }
}



