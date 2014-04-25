<?php

class ClassTemplateTest extends PHPUnit_Framework_TestCase
{
    public function testUse()
    {
        $use = new ClassTemplate\UseClass('\Foo\Bar');
        is( 'Foo\Bar', $use->class );
    }

    public function testClassTemplateWithDefaultOptions() 
    {
        $classTemplate = new ClassTemplate\ClassTemplate('Foo\\Bar2');
        ok($classTemplate);
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', [ 'lang', 'name' ] );
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');

        $code = $classTemplate->render();
        $tmpname = tempnam('/tmp','FOO');
        file_put_contents($tmpname, $code);
        require $tmpname;
    }

    public function testClassTemplate()
    {
        $classTemplate = new ClassTemplate\ClassTemplate('Foo\\Bar1',array(
            'template' => 'Class.php.twig',
            'template_dirs' => array('src/ClassTemplate/Templates'),
        ));
        ok($classTemplate);
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', [ 'lang', 'name' ] );
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');

        $code = $classTemplate->render();
        $tmpname = tempnam('/tmp','FOO');
        file_put_contents($tmpname, $code);
        require $tmpname;

        ok(class_exists($classTemplate->class->getFullName()));

        $bar22 = new Foo\Bar1;
        ok($bar22);

        is('Product', $bar22->record);
        is(['lang','name'], $bar22->fields);

        ok(method_exists($bar22,'getTwo'));
        ok(method_exists($bar22,'getFoo'));

        is(2,$bar22->getTwo());

        is(3,$bar22->getFoo(3));
        unlink($tmpname);
    }


}

