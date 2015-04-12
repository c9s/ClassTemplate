<?php
namespace ClassTemplate;

class Raw
{
    public function __construct($code)
    {
        $this->code = $code;
    }

    public function __toString() 
    {
        return $this->code;
    }
}




