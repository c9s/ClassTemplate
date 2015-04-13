<?php
namespace ClassTemplate;
use Exception;
use ClassTemplate\Renderable;
use ClassTemplate\Raw;
use LogicException;

class MethodCallExpr implements Renderable
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

    public function serializeArguments(array $args) 
    {
        $strs = array();
        foreach ($args as $arg) {
            if (is_string($arg) && $arg[0] == '$') {
                $strs[] = $arg;
            } else if ($arg instanceof Renderable) {
                $strs[] = $arg->render($args);
            } else if ($arg instanceof Raw) {
                $strs[] = $arg;
            } else if (is_array($arg) || method_exists($arg,"__set_state") || is_scalar($arg)) {
                $str = var_export($arg, true);
                $strs[] = $str;
            } else {
                throw new LogicException("MethodCall template: Unsupported argument type.");
            }
        }
        return join(', ',$strs);
    }

    public function render(array $args = array()) {
        return $this->objectName . '->' . $this->method . '(' . $this->serializeArguments($this->arguments) . ')';
    }

    public function __toString() {
        return $this->render();
    }
    
}



