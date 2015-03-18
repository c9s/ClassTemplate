<?php
namespace ClassTemplate;
use Exception;
use ClassTemplate\Renderable;

class MethodCall extends Statement implements Renderable
{
    public $objectName;

    public $method;

    public $arguments = array();

    public function __construct($objname = 'this') {
        $this->objectName = $objname;
    }

    public function method($name) 
    {
        $this->method = $name;
        return $this;
    }

    public function addArgument($arg) 
    {
        $this->arguments[] = $arg;
        return $this;
    }

    public function render(array $args = array()) {
        $code = '';
        $code .= '$' . $this->objectName;
        $code .= '->' . $this->method . '(';

        $strs = array();
        foreach( $this->arguments as $arg ) {
            if( is_string($arg) && $arg[0] == '$' ) {
                $strs[] = $arg;
            } 
            elseif( is_string($arg) ) {
                $strs[] = $arg;
            }
            elseif( is_array($arg) ) {
                $str = var_export($arg,true);
                $strs[] = $str;
            }
            else {
                throw new Exception("MethodCall template: Unsupported argument type.");
            }
        }
        $code .= join(',',$strs);
        $code .= ');';
        return $code;
    }

    public function __toString() {
        return $this->render();
    }
    
}



