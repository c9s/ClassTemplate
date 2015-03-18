<?php
use ClassTemplate\Testing\CodeGenTestCase;
use ClassTemplate\CommentBlock;

class CommentBlockTest extends CodeGenTestCase
{
    public function testCommentBlock()
    {
        $comment = new CommentBlock;
        $comment[] = 'first line';
        $comment[] = 'second line';
        $this->assertCodeEqualsFile('tests/data/comment_block.fixture',$comment);
    }
}

