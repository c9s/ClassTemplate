<?php
namespace ClassTemplate;

abstract class Statement {
    abstract public function render();

    public function __toString()
    {
        return $this->render();
    }
}



