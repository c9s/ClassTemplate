<?php
use ClassTemplate\Block;
use ClassTemplate\BracketedBlock;

class BracketedBlockTest extends PHPUnit_Framework_TestCase
{
    public function testSimpleBracketedBlock()
    {
        $block = new BracketedBlock;
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';
        $block[] = 'return $a + $b;';
        $this->assertStringEqualsFile('tests/data/bracketed_block_simple.fixture',$block->render());
    }
}

