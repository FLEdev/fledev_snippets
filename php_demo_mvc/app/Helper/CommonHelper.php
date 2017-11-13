<?php

namespace Helper;

class CommonHelper{
    public function __construct()
    {
        
    }

    /**
     * @param $string
     * @return string
     */
    public static function escapeString($string) : string
    {
        $returnString = addslashes($string);
        returnhtmlspecialchars_decode($returnString);
    }

    public static function getTwig() :\Twig_Environment
    {
        $loader = new \Twig_Loader_Filesystem(BASE_PATH_DIR . '/app/Resources/views/');
        $twig = new \Twig_Environment($loader,
            array(
                'cache' => false,
            ));
       return $twig;
    }
}