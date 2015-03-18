<?php
namespace ClassTemplate;
use ClassTemplate\Utils;
use ClassTemplate\Renderable;
use ClassTemplate\Indenter;

class ClassMethod extends UserFunction implements Renderable
{
    public $scope = 'public';

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    public function render(array $args = array())
    {
        $block = $this->getBlock();
        $block->setIndent(1);
        return Indenter::indent(1)  . $this->scope . ' function ' . $this->name . '(' . $this->renderArguments() . ")\n" 
            . $block->render($args)
            ;
    }

    public function __toString() {
        return $this->render();
    }



}

