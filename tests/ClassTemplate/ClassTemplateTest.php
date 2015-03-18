<?php
namespace Foo {
    trait TraitA { 
        public function hello() {
            return 'hello from A';
        }
    }

    trait TraitB { 
        public function hello() {
            return 'hello from B';
        }
    }
}

namespace {

class ClassTemplateTest extends PHPUnit_Framework_TestCase
{
    public function testUse()
    {
        $use = new ClassTemplate\UseClass('\Foo\Bar');
        is( 'Foo\Bar', $use->class );
    }

    public function testClassTemplateWithDefaultOptions() 
    {
        $classTemplate = new ClassTemplate\ClassDeclare('Foo\\Bar2');
        ok($classTemplate);
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', [ 'lang', 'name' ] );
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');
        $classTemplate->load();
    }

    public function evalTemplate(ClassTemplate\ClassDeclare $classTemplate)
    {
        $code = $classTemplate->render();
        $tmpname = tempnam('/tmp', preg_replace('/\W/', '_', $classTemplate->class->getFullName()));
        file_put_contents($tmpname, $code);
        require $tmpname;
    }

    public function testClassTemplate()
    {
        $classTemplate = new ClassTemplate\ClassDeclare('Foo\\Bar1',array(
            'template' => 'Class.php.twig',
            'template_dirs' => array('src/ClassTemplate/Templates'),
        ));
        ok($classTemplate);
        $classTemplate->addProperty('record','Product');
        $classTemplate->addProperty('fields', [ 'lang', 'name' ] );
        $classTemplate->addMethod('public','getTwo',array(),'return 2;');
        $classTemplate->addMethod('public','getFoo',array('$i'),'return $i;');

        $this->evalTemplate($classTemplate);

        ok(class_exists($classTemplate->class->getFullName()));

        $bar22 = new Foo\Bar1;
        ok($bar22);

        is('Product', $bar22->record);
        is(['lang','name'], $bar22->fields);

        ok(method_exists($bar22,'getTwo'));
        ok(method_exists($bar22,'getFoo'));

        is(2,$bar22->getTwo());

        is(3,$bar22->getFoo(3));
    }

    public function testTraitUseInsteadOf() {
        $classTemplate = new ClassTemplate\ClassDeclare('Foo\\TraitTest',array(
            'template' => 'Class.php.twig',
            'template_dirs' => array('src/ClassTemplate/Templates'),
        ));
        $classTemplate->useTrait('TraitA', 'TraitB')
            ->useInsteadOf('TraitA::hello', 'TraitB');
        $this->evalTemplate($classTemplate);
    }

    public function testTraitUseAs() {
        $classTemplate = new ClassTemplate\ClassDeclare('Foo\\TraitUseAsTest',array(
            'template' => 'Class.php.twig',
            'template_dirs' => array('src/ClassTemplate/Templates'),
        ));
        $classTemplate->useTrait('TraitA', 'TraitB')
            ->useInsteadOf('TraitB::hello', 'TraitA')
            ->useAs('TraitA::hello', 'talk');
        $this->evalTemplate($classTemplate);

        $foo = new Foo\TraitUseAsTest;
        ok($foo);
        is('hello from A',$foo->talk());
        is('hello from B',$foo->hello());
    }

}

}
