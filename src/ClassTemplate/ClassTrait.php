<?php
namespace ClassTemplate;

/**
 * use HelloWorld { sayHello as private myPrivateHello; }
 * use HelloWorld { sayHello as protected; }
 *
 * use A, B {
 *      B::smallTalk insteadof A;
 *      A::bigTalk insteadof B;
 * }
 *
 * class Aliased_Talker {
 *    use A, B {
 *      B::smallTalk insteadof A;
 *      A::bigTalk insteadof B;
 *      B::bigTalk as talk;
 *    }
 * }
 */
class ClassTrait
{
    public $classes = array();

    public $definitions = array();

    public function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    public function useInsteadOf($aMethod, $b) {
        $this->definitions[] = "$aMethod insteadof $b;";
        return $this;
    }

    public function useAs($aMethod, $methodB) {
        $this->definitions[] = "$aMethod as $methodB;";
        return $this;
    }

    public function __toString() {
        $out = "use " . join(', ', $this->classes);

        if (empty($this->definitions)) {
            $out .= ";";
        } else {
            $out .= " {\n";
            foreach($this->definitions as $def) {
                $out .= "  " . $def . "\n";
            }
            $out .= "}\n";
        }
        return $out;
    }
}



