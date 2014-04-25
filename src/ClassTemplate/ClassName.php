<?php
namespace ClassTemplate;

class ClassName extends Statement
{
    public $name;
    public $namespace;

    public $root = false;

    public function __construct($className)
    {
        if ( $className[0] == '\\' ) {
            $this->root = true;
            $className = substr($className,1);
        }

        // found namespace
        if( strpos( $className , '\\' ) != false ) {
            $p = explode('\\',ltrim($className, '\\'));
            $this->name = end($p);
            $this->namespace = join('\\',array_splice( $p , 0 , count($p) - 1 ));
        }
        else {
            $this->name = $className;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        if ( $this->namespace ) {
            return ($this->root ? '\\' : '') .  $this->namespace . '\\' . $this->name;
        } else {
            return ($this->root ? '\\' : '') . $this->name;
        }
    }

    public function render()
    {
        return $this->getFullName();
    }

}

