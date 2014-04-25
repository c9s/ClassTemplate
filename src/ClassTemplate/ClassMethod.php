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

    public function render()
    {
        return Utils::indent(1)  . $this->scope . ' function ' . $this->name . '(' . $this->renderArguments() . ') ' 
            . $this->renderBody(1);
    }
}

