<?php
namespace ClassTemplate;
use Exception;
use ReflectionClass;
use ReflectionObject;

class ClassTemplate
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

    /**
     * @var TemplateView object.
     */
    protected $view;

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
    public function __construct($className,$options = array())
    {
        if( !isset($options['template_dirs']) ) {
            $ro = new ReflectionObject($this);
            $dir = dirname($ro->getFilename()) . DIRECTORY_SEPARATOR . 'Templates';
            $options['template_dirs'] = [ $dir ];
        }
        if( !isset($options['template']) ) {
            $options['template'] = 'Class.php.twig';
        }

        $this->options = $options;
        $this->templateFile = $options['template'];
        $this->templateDirs = $options['template_dirs'];
        $this->setClass($className);

        $this->view = new TemplateView($this->templateDirs, 
            (isset($options['twig']) ? $options['twig'] : array()),
            (isset($options['template_args']) ? $options['template_args'] : array())
        );
        $this->view->class = $this;
    }

    public function setOption($key, $val) {
        $this->options[$key] = $val;
    }

    public function setClass($className)
    {
        $this->class = new ClassName( $className );
    }

    public function useClass($className, $as = null)
    {
        if ( $as ) {
            if ( isset($this->usedClasses[$as]) ) {
                return;
            }
            $this->usedClasses[$as] = $className;
        } else {
            if ( isset($this->usedClasses[$className]) ) {
                return;
            }
            $this->usedClasses[$className] = $className;
        }
        $this->uses[] = new UseClass( $className, $as );
    }

    public function extendClass($className, $absolute = false)
    {
        if ( $className[0] == '\\' || $absolute ) {
            $className = ltrim($className,'\\');
            $this->useClass($className);

            $_p = explode('\\',$className);
            $shortClassName = end($_p);
            $this->extends = new ClassName($shortClassName);
        } else {
            $this->extends = new ClassName($className);
        }
    }

    public function implementClass($className)
    {
        $this->interfaces[] = new ClassName($className);
    }

    public function addMethod($scope,$methodName,$arguments = array(),$body = null, $bodyArguments = array() )
    {
        $method = new ClassMethod( $methodName, $arguments, $body , $bodyArguments);
        $method->setScope($scope);
        $this->methods[] = $method;
        return $method;
    }

    public function addConst($name,$value)
    {
        $this->consts[] = new ClassConst($name,$value);
    }

    public function addConsts($array) {
        foreach( $array as $name => $value ) {
            $this->consts[] = new ClassConst($name,$value);
        }
    }

    public function addProperty($name,$value,$scope = 'public')
    {
        $this->properties[] = new ClassProperty($name,$value,$scope);
    }

    public function addStaticVar($name, $value, $scope = 'public') 
    {
        $this->staticVars[] = new ClassStaticVariable($name, $value, $scope);
    }



    /**
     * Returns the short class name
     *
     * @return string short class name
     */
    public function getShortClassName() 
    {
        return $this->class->getName();
    }

    public function getClassName()
    {
        return $this->class->getFullName();
    }

    public function __set($n,$v) {
        $this->view->__set($n,$v);
    }

    public function render($args = array())
    {
        foreach( $args as $n => $v ) {
            $this->view->__set($n,$v);
        }
        $content = $this->view->renderFile($this->templateFile);
        if ( isset($this->options['trim_tag']) && strpos($content, '<?php') === 0 ) {
            return substr($content, 5);
        }
        return $content;
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


    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }


    public function addMsgId($msgId) {
        $this->msgIds[] = $msgId;
    }

    public function setMsgIds($msgIds) {
        $this->msgIds = $msgIds;
    }

    public function addTrait($class) {
        $classes = func_get_args();
        $stat = new ClassTrait($classes);
        $this->traits[] = $stat;
        return $stat;
    }

}

