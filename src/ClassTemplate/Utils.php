<?php
namespace ClassTemplate;

class Utils
{
    static public renderStringTemplate($templateContent, $args = array()) {
        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);
        return $twig->render($templateContent, $args);
    }
}




