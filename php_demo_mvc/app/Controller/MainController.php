<?php

namespace Controller;

use Controller\UserOverwrite\User;
use Helper\{CommonHelper, UserHelper};

class MainController {

    public function __construct()
    {

    }

    public function homeAction($arguments) :string
    {
        $twig = CommonHelper::getTwig();
        $template = 'index.html.twig';
        return $twig->render($template, [
            'title' => 'Main Page',
            'main' => 'Home - Main Content',
            'sidebar' => $this->getSidebar($twig),
        ]);
    }

    public function loginAction($arguments) :string
    {
        $loginData = $this->getLoginData();
        if(!empty($loginData['email']) && !empty($loginData['password'])) {
            UserHelper::checkLogin($loginData['email'], $loginData['password']);
        }

        $twig = CommonHelper::getTwig();
        $template = 'index.html.twig';
        return $twig->render($template, [
            'title' => 'Main Page',
            'main' => 'Home - Main Content',
            'sidebar' => $this->getSidebar($twig),
        ]);
    }



    public function logoutAction() :void
    {
        session_start();
        session_regenerate_id();
        $_SESSION = array();
        session_destroy();
    }

    public function dummyAction($arguments){
        echo ' dummy ';
        print_r($arguments);
    }

    private function getSidebar($twig) {
        $sidebar = 'sidebar.html.twig';
        return $twig->render($sidebar, ['uid' => UserHelper::getUserLogin()]);
    }

    private function getLoginData() :array
    {
        return [
            'email' => isset($_POST['email']) ? $_POST['email'] : '',
            'password' => isset($_POST['password']) ? $_POST['password'] : ''
        ];
    }
}