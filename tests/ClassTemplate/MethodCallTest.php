<?php
use ClassTemplate\Raw;

class MethodCallTest extends PHPUnit_Framework_TestCase
{
    function test()
    {
        $call = new ClassTemplate\MethodCall;
        $call->method('doSomething');
        $call->addArgument(123);
        $call->addArgument('foo');
        $call->addArgument(new Raw('new SplObjectStorage'));
        $call->addArgument(array( 'name' => 'hack' ));
        $str = $call->render();
        ok($str);
        is("\$this->doSomething(123, 'foo', new SplObjectStorage, array (\n  'name' => 'hack',\n));",$str);
    }
}

