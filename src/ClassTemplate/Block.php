<?php
namespace ClassTemplate;
use ClassTemplate\Utils;

class Block
{
    public $lines = array();

    public $args = array();

    public $indent = 0;

    public $autoIndent = true;

    public function setDefaultArguments(array $args)
    {
        $this->args = $args;
    }

    public function autoIndent($v = true) {
        $this->autoIndent = $v;
    }

    public function setBody($text) {
        $this->lines = explode("\n", $text);
    }

    public function appendLine($line) {
        $this->lines[] = $line;
    }

    public function indent() {
        $this->indent++;
    }

    public function unindent() {
        $this->indent--;
    }

    public function setIndent($indent) {
        $this->indent = $indent;
    }

    public function render($args = array(), $allowIndent = true) {
        if (!$allowIndent || !$this->autoIndent ) {
            $body = join("\n",$this->lines) . "\n";
        } else {
            $space = str_repeat("    ", $this->indent);
            $body = $space . join("\n" . $space,$this->lines) . "\n";
        }
        return Utils::renderStringTemplate($body, array_merge($this->args,$args));
    }

}




