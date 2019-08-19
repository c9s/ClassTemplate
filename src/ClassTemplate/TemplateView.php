<?php

namespace ClassTemplate;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateView
{
    private $loader;
    private $twig;
    public $stash = array();

    public function __construct( $dirs , $options = array(), $stash = array() )
    {
        $this->loader = new FilesystemLoader( $dirs );
        $this->twig = new Environment($this->loader, array(
            'cache' => false,
            'auto_reload' => true,
            'autoescape' => false,
            'debug' => true,
        ) + $options );
        $this->stash = $stash;
    }

    public function __set($n,$v)
    {
        $this->stash[ $n ] = $v;
    }

    public function __get($n)
    {
        return $this->stash[ $n ];
    }

    public function renderFile($file)
    {
        return $this->twig->load($file)->render($this->stash);
    }
}

