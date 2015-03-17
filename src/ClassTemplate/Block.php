<?php
namespace ClassTemplate;
use ClassTemplate\Utils;
use ClassTemplate\Renderable;
use InvalidArgumentException;
use ArrayAccess;
use IteratorAggregate;
use ArrayIterator;


/**
 * A block class can generate multiple-linke block code.
 *
 * It uses line-based unit to generate code, however the added 
 * element doesn't have to be string, it can be anything 
 * stringify-able objects (support __toString() method) or 
 * implemented with Renderable interface.
 */
class Block implements IteratorAggregate, ArrayAccess
{
    public $lines = array();

    public $args = array();

    /**
     * The default indent level.
     */
    public $indent = 0;

    /**
     * Auto indent is supported by default
     */
    public $autoIndent = true;


    public function setDefaultArguments(array $args)
    {
        $this->args = $args;
        return $this;
    }

    public function autoIndent($v = true) {
        $this->autoIndent = $v;
        return $this;
    }


    /**
     * Allow text can be set with array
     */
    public function setBody($text) {
        if (is_string($text)) {
            $this->lines = explode("\n", $text);
        } elseif (is_array($text)) {
            $this->lines = $text;
        } else {
            throw new InvalidArgumentException("Invalid body type");
        }
    }

    public function appendRenderable(Renderable $obj)
    {
        $this->lines[] = $line;
    }

    public function appendLine($line) {
        $this->lines[] = $line;
    }

    public function indent() 
    {
        $this->indent++;
    }

    public function unindent()
    {
        $this->indent--;
    }

    public function splice($from, $length, array $replacement = array()) 
    {
        return array_splice($this->lines, $from, $length, $replacement);
    }


    public function setIndent($indent) {
        $this->indent = $indent;
    }

    public function render(array $args = array()) {
        $space = str_repeat("    ", $this->indent);
        $body = '';
        foreach($this->lines as $line) {
            if (is_string($line)) {
                $body .= $space . $line . "\n";
            } else if ($line instanceof Renderable) {
                $body .= $space . $line->render() . "\n";
            } else {
                throw new Exception("Unsupported line object.");
            }
        }
        return Utils::renderStringTemplate($body, array_merge($this->args,$args));
    }

    // ============ interface ArrayAggregator implementation =============
    public function getIterator() 
    {
        return new ArrayIterator($this->lines);
    }

    // ============ interface ArrayAccess implementation =============
    public function offsetSet($key,$value)
    {
        if ($key) {
            $this->lines[$key] = $value;
        } else {
            $this->lines[] = $value;
        }
    }
    
    public function offsetExists($key)
    {
        return isset($this->lines[ $key ]);
    }
    
    public function offsetGet($key)
    {
        return $this->lines[ $key ];
    }
    
    public function offsetUnset($key)
    {
        unset($this->lines[$name]);
    }
    

}




