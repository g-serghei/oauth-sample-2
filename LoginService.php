<?php

class LoginService
{
    const LOGIN_SERVER = 'http://127.0.0.1:8000';
    const CURRENT_SERVER_NAME = 's1';

    static function isLogged(): bool
    {
        return !empty($_SESSION['user']);
    }

    static function redirectToLogin() {
        header('Location: '.self::LOGIN_SERVER.'/login?server='.self::CURRENT_SERVER_NAME);
        die();
    }

    static function redirectToHome() {
        header('Location: /index.php');
        die();
    }

    static function checkLogin()
    {
        if (!self::isLogged()) {
            self::redirectToLogin();
        }
    }

    static function login()
    {
        if (self::isLogged()) {
            self::redirectToHome();
        }

        if (empty($_GET['token'])) {
            self::redirectToLogin();
        }

        $server = self::CURRENT_SERVER_NAME;
        $token = $_GET['token'];

        try {
            $response = json_decode(
                file_get_contents(self::LOGIN_SERVER . "/validate-token?server={$server}&token={$token}"),
                true
            );

            if (!$response['valid']) {
                self::redirectToLogin();
            }

            $_SESSION['user'] = $response['user'];

            self::redirectToHome();
        } catch (Exception $e) {
            self::redirectToLogin();
        }
    }

}

