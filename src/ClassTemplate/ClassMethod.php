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

    protected function renderBody($indent = 0) 
    {
        return "{\n" . $this->getBlock()->render() . Utils::indent(1) . "}\n" ;
    }

    public function render()
    {
        return Utils::indent(1)  . $this->scope . ' function ' . $this->name . '(' . $this->renderArguments() . ') '
            . $this->renderBody(1);
    }



}

