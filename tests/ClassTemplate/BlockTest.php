<?php

class BlockTest extends PHPUnit_Framework_TestCase
{
    public function testBlock()
    {
        $block = new ClassTemplate\Block;
        $block->setBody('${{name}} = 1;');
        $block->appendLine('${{name}} = ${{name}} + 1;');
        $block->appendLine('return ${{name}};');
        $code = $block->render(array( 
            'name' => 'a'
        ));
        ok($code);
        $ret = eval($code);
        is(2, $ret);
    }
}

