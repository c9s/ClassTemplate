<?php
namespace ClassTemplate;

class ClassStaticVariable extends Statement
{
    public $name;
    public $value;
    public $scope;

    public function __construct($name,$value,$scope = 'public')
    {
        $this->name = $name;
        $this->value = $value;
        $this->scope = $scope;
    }

    public function render()
    {
        return $this->scope . ' static $' . $this->name . ' = ' . var_export($this->value,true) . ';';
    }
}

