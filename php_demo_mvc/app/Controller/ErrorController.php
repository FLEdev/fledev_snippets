<?php

namespace Controller;

use Helper\CommonHelper;

class ErrorController{
    public function __construct()
    {
    }

    public function errorPageAction($parameters) {
        $template = 'error.html.twig';

        $twig = CommonHelper::getTwig();
        return $twig->render($template, [
            'title' => 'Main Page',
            'main' => 'Oops, an Error occured, please review your request.',
        ]);
    }
}