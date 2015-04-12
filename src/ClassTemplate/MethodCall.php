<?php
namespace ClassTemplate;
use Exception;
use ClassTemplate\Renderable;

class MethodCall extends Statement implements Renderable
{
    public $objectName;

    public $method;

    public $arguments = array();

    public function __construct($objectName = '$this', $method = NULL, array $arguments = NULL) {
        $this->objectName = $objectName;
        if ($method) {
            $this->method = $method;
        }
        if ($arguments) {
            $this->arguments = $arguments;
        }
    }

    public function method($name) 
    {
        $this->method = $name;
        return $this;
    }

    public function setArguments(array $args)
    {
        $this->arguments = $args;
    }

    public function addArgument($arg) 
    {
        $this->arguments[] = $arg;
        return $this;
    }

    public function render(array $args = array()) {
        $code = $this->objectName . '->' . $this->method . '(';
        $strs = array();
        foreach ($this->arguments as $arg) {
            if (is_string($arg) && $arg[0] == '$') {
                $strs[] = $arg;
            } else if (is_string($arg)) {
                $strs[] = $arg;
            } else if (is_array($arg)) {
                $str = var_export($arg,true);
                $strs[] = $str;
            } else {
                throw new Exception("MethodCall template: Unsupported argument type.");
            }
        }
        $code .= join(', ',$strs);
        $code .= ');';
        return $code;
    }

    public function __toString() {
        return $this->render();
    }
    
}



