<?php
namespace ClassTemplate;
use ClassTemplate\Renderable;

abstract class Statement {

    public function __toString()
    {
        return $this->render();
    }
}



