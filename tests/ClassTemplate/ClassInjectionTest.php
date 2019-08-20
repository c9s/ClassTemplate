<?php

use PHPUnit\Framework\TestCase;

class ClassInjectionTest extends TestCase
{
    function test()
    {
        // create test class file
        file_put_contents('tests/tmp_class',<<<'CODE'
<?php
class InjectFoo {
    public $value = 2;
    public function __toString() {
        return $this->getValue();
    }
}
CODE
);
        require 'tests/tmp_class';
        $foo = new InjectFoo;
        $this->assertTrue($foo);

        $inject = new ClassTemplate\ClassInjection($foo);
        $this->assertTrue($inject);

        $inject->read();


        // so that we have getValue method now.
        $inject->appendContent('
            function getValue() {
                return $this->value;
            }
        ');

        $inject->write();

        // file_put_contents('tests/data/injected', $inject);
        $this->assertEquals( file_get_contents('tests/data/injected'), $inject->__toString() );

        $inject->read();
        $this->assertEquals( file_get_contents('tests/data/injected'), $inject->__toString() );

        $inject->write();
        $this->assertEquals( file_get_contents('tests/data/injected'), $inject->__toString() );


        $inject->replaceContent('');
        $inject->write();

        // file_put_contents('tests/data/replaced',$inject);
        $this->assertEquals( file_get_contents('tests/data/replaced'), $inject->__toString() );


        // TODO test the content
        unlink('tests/tmp_class');
    }
}

