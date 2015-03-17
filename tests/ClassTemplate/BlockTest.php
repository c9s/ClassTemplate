<?php
use ClassTemplate\Block;

class BlockTest extends PHPUnit_Framework_TestCase
{
    public function testBlockWithSetBody()
    {
        $block = new Block;
        $block->setBody('${{name}} = 1;');
        $block->appendLine('${{name}} = ${{name}} + 1;');
        $block->appendLine('return ${{name}};');
        $code = $block->render(array( 
            'name' => 'a'
        ));
        $this->assertNotEmpty($code);
        $ret = eval($code);
        $this->assertEquals(2, $ret);
    }

    public function testAppendLineMethodAndArrayAggregate() {
        $block = new Block;
        $block->appendLine('$a = 1;');
        $block->appendLine('$b = 2;');
        $block->appendLine('return $a + $b;');
        foreach($block as $line) {
            $this->assertNotEmpty($line);
            $ret = eval($line);
        }
    }

    public function testAppendLineWithOffsetSet() {
        $block = new Block;
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';
        $block[] = 'return $a + $b;';
        $code = $block->render();
        $result = eval($code);
        $this->assertEquals(3, $result);
    }

    public function testAppendLineWithOffsetGet() {
        $block = new Block;
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';
        $block[] = 'return $a + $b;';
        $this->assertEquals('$a = 1;', $block[0]);
        $this->assertEquals('$b = 2;', $block[1]);
    }

    public function testSingleLevelIndentation() {
        $block = new Block;
        $block->indent();
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';
        $block[] = '$c = 3;';
        $code = $block->render();
        $this->assertStringEqualsFile('tests/data/simple_block.fixture', $code);
    }


    public function testMultiLevelIndentation() {
        $block = new Block;
        $block->increaseIndentLevel();
        $block[] = '$a = 1;';
        $block[] = '$b = 2;';
        $block[] = '$c = 3;';
        $block[] = '{';
        $subBlock = new Block;
        $subBlock->increaseIndentLevel();
        $subBlock[] = '$f = $a + $b;';
        $subBlock[] = '$g = $b + $c;';
        $block[] = $subBlock;
        $block[] = '}';
        $code = $block->render();
        $this->assertStringEqualsFile('tests/data/multi_level_block.fixture', $code);
    }

}

