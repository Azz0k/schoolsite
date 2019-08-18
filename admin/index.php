<?php
    session_start();
    foreach (glob($_SERVER['DOCUMENT_ROOT'].'/includes/php/*.php') as $file){
        require_once $file;
    }
    $isUserAuthorized = false;
    $database = null;
    $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'].'/init.ini';
    $initialValues = parse_ini_file($MAIN_INI_FILE,false, INI_SCANNER_TYPED);
    $csrfToken =null;
    if (isset($_COOKIE['login'])){
        list($username, $cookiehash) = explode(',', $_COOKIE['login']);
        $database = new Database($initialValues);
        $isUserAuthorized = $database->validateCookie($username, $cookiehash);
    }
    if (!$isUserAuthorized) {
       if (!isset($_POST['submit_login'])) {
            openLoginForm($initialValues);
        } else {
            $csrfToken = $_SESSION['csrfToken'];
            $database = new Database($initialValues);
            $_POST['username'] = trim($_POST['username']);
            $isUserAuthorized = $database->validateUserPassword($csrfToken);
            if ($isUserAuthorized) {
                $cookiehash = getToken(250);
                setcookie('login', $_POST['username'] . ',' . $cookiehash, 0, '/', '', false, true);//cookie expires after browser closed
                $database->storeCookie($_POST['username'], $cookiehash);
                //echo 'Authorized';
            }
        }
    }
    if ($isUserAuthorized){
        include $_SERVER['DOCUMENT_ROOT'] . $initialValues['html'] . '/panel.html.php';
        exit();
    }
    else {
        openLoginForm($initialValues, false);
    }

