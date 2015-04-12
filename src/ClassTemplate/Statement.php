<?php
namespace ClassTemplate;
use ClassTemplate\Renderable;

class Statement extends Line 
{
    public $expr;

    public function __construct(Renderable $expr) {
        $this->expr = $expr;
    }

    public function render() {
        return $this->expr->render() . ';';
    }

}



