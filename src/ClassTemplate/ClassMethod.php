<?php
namespace ClassTemplate;
use ClassTemplate\Utils;

class ClassMethod extends UserFunction
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
        return Utils::indent(1)  . $this->scope . ' function ' . $this->name . '(' . $this->renderArguments() . ")\n" 
            . $block->render($args)
            ;
    }



}

