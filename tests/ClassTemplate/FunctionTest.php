<?php

class UserFunctionTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $func = new ClassTemplate\UserFunction('user_foo', ['$i', '$x = 2'], 'return $i + $x;');
        ok($func);
        ok($func->__toString());
        eval($func->__toString());

        // echo $func->__toString();

        is(3, user_foo(1));
        is(2, user_foo(1,1));
        is(3, user_foo(1,2));
    }
}

