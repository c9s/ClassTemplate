<?php
namespace ClassTemplate;
use Exception;
use ReflectionClass;
use ReflectionObject;
use CodeGen\UserClass;
use CodeGen\Renderable;

class ClassFile extends UserClass
{
    public $class;

    public $extends;

    public $interfaces = array();

    public $uses = array();

    public $methods = array();

    public $consts  = array();

    public $properties = array();

    public $staticVars = array();

    /**
     * Registered trait
     */
    public $traits = array();

    public $templateFile;
    public $templateDirs;
    public $options = array();
    public $msgIds = array();


    public $usedClasses = array();

    /**
     * constructor create a new class template object
     *
     * @param string $className
     * @param array $options 
     *
     * a sample options:
     * 
     * $t = new ClassTemplate('NewClassFoo',[
     *   'template_dirs' => [ path1, path2 ],
     *   'template' => 'Class.php.twig',
     *   'template_args' => [ ... predefined template arguments ],
     *   'twig' => [ 'cache' => false, ... ]
     * ])
     *
     */
    public function __construct($className, array $options = array())
    {
        parent::__construct($className);
        $this->setOptions($options);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function setOption($key, $val) {
        $this->options[$key] = $val;
    }

    public function render(array $args = array())
    {
        return "<?php\n" . parent::render($args);
    }

    public function writeTo($file)
    {
        return file_put_contents($file, $this->render());
    }

    public function load() {
        $tmpname = tempnam('/tmp', str_replace('\\','_',$this->class->getFullName()) );
        file_put_contents($tmpname, $this->render() );
        return require $tmpname;
    }

    public function addMsgId($msgId)
    {
        $this->msgIds[] = $msgId;
    }

    public function setMsgIds($msgIds)
    {
        $this->msgIds = $msgIds;
    }
}

