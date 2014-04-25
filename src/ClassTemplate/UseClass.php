<?php
namespace ClassTemplate;

class UseClass extends Statement
{
    public $as;
    public $class;

    public function __construct($class,$as = null)
    {
        $this->class = ltrim( $class , '\\' );
        $this->as = $as ? ltrim($as,'\\') : null;
    }

    public function render()
    {
        $code = 'use ' . $this->class;
        if( $this->as ) {
            $code .= ' ' . $this->as;
        }
        return $code . ';';
    }
}
