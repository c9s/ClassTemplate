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

    public function testSimpleBracketedBlockAndSubBlock()
    {
        $block = new BracketedBlock;
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';

        $subblock = new BracketedBlock;
        $subblock[] = '$e = $a + $b;';
        $subblock[] = '$f = $a * $b;';
        $block[] = $subblock;
        $block[] = 'return $a + $b;';
        $this->assertStringEqualsFile('tests/data/bracketed_block_subblock.fixture', $block->render());
    }
}

