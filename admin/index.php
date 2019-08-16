<?php
    session_start();
    foreach (glob($_SERVER['DOCUMENT_ROOT'].'/includes/php/*.php') as $file){
        require_once $file;
    }
    $database = null;
    $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'].'/init.ini';
    $initialValues = parse_ini_file($MAIN_INI_FILE,false, INI_SCANNER_TYPED);
    $lenght = 32;
    $csrfToken = openssl_random_pseudo_bytes($lenght);
    $csrfToken = substr(bin2hex($csrfToken), 0, $lenght);
    if (!isset($_POST['submit_login'])){
        $_SESSION['csrfToken'] = $csrfToken;
        include $_SERVER['DOCUMENT_ROOT'] . $initialValues['html'] . '/autorization.html.php';
        exit();
    }
    else{
        $csrfToken = $_SESSION['csrfToken'];
        $database = new Database($initialValues);
        $isAutorized = $database->validateUserPassword($csrfToken);
        if ($isAutorized) echo 'Autorized';
        else echo 'Forbidden';
        //todo username в базе сделать уникальным. хранить хеши паролей. Прикрутить куку
    }

