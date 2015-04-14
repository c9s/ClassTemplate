<?php
namespace ClassTemplate;
use Exception;
use ClassTemplate\Renderable;
use ClassTemplate\Raw;
use ClassTemplate\VariableDeflator;
use LogicException;

/**
 * This is a shorthand class for generating $this->foo( ... );
 */
class SelfMethodCallExpr extends MethodCallExpr
{
    public function __construct($method = NULL, array $arguments = NULL) {
        parent::__construct('$this');
    }
}

