<?php
namespace ClassTemplate;

class ClassProperty extends Statement
{
    public $name;
    public $scope = 'public';
    public $value;

    public function __construct($name,$value,$scope = 'public')
    {
        $this->name = $name;
        $this->value = $value;
        $this->scope = $scope;
    }


    public function render()
    {
        $code = $this->scope . ' $' . $this->name;
        if ( $this->value ) {
            $code .= ' = ' . var_export($this->value,true) . ';';
        }
        return $code;
    }

}

