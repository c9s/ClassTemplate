<?php
namespace ClassTemplate;
use ClassTemplate\Block;

/**
 * A BracketedBlock is a block that uses bracket to wrap the inner block.
 */
class BracketedBlock extends Block
{
    public function render(array $args = array()) 
    {
        $space = str_repeat('    ', $this->indentLevel);
        $this->increaseIndentLevel(); // increaseIndentLevel to indent the inner block.
        $body  = '';
        $body .= $space . "{\n";
        $body .= parent::render($args);
        $body .= $space . "}\n";
        return $body;
    }

}




