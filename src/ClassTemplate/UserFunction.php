<?php
namespace ClassTemplate;
use ClassTemplate\Block;

class UserFunction extends Statement
{
    public $name;
    public $arguments = array();

    public $body;
    public $bodyArguments = array();

    public $block;

    /**
     * Class Method Constructor
     *
     * @param string $name the function name.
     * @param array $arguments the argument of the function prototype.
     * @param string $body the code of the function.
     * @param array $bodyArguments the template arguments of the code of the function.
     */
    public function __construct($name, $arguments = array(), $body = '', $bodyArguments = array() )
    {
        $this->name = $name;
        $this->arguments = $arguments;

        $this->block = new Block;
        if ($body) {
            $this->block->setBody($body);
        }
        if ($bodyArguments) {
            $this->block->setDefaultArguments($bodyArguments);
        }
    }


    public function setBlock(Block $block)
    {
        $this->block = $block;
    }

    public function getBlock() {
        return $this->block;
    }

    public function setArguments(array $args) 
    {
        $this->arguments = $args;
    }

    protected function renderArguments() 
    {
        return join(', ', $this->arguments);
    }

    public function render() {
        return 'function ' . $this->name . '(' . $this->renderArguments() . ') '
            . "{\n" 
            . $this->getBlock()->render() 
            . "}\n";
    }


}





