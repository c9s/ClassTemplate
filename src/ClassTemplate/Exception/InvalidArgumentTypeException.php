<?php
namespace ClassTemplate\Exception;
use InvalidArgumentException;

class InvalidArgumentTypeException extends InvalidArgumentException
{
    public $expectingTypes = array();

    public $givenType;

    public function __construct($message, $givenType, array $expectingTypes = array()) {
        parent::__construct($message);
        $this->givenType = $givenType;
        $this->expectingTypes = $expectingTypes;
    }
}



