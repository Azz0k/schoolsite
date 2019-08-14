<?php
    foreach (glob(_SERVER['DOCUMENT_ROOT'].'/includes/*.inc.php') as $file){
        include $file;
    }
    $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'].'/init.ini';
    $initialValues = parse_ini_file($MAIN_INI_FILE,false, INI_SCANNER_TYPED);
    $dsn = $initialValues['base'].':host='.$initialValues['host'].';dbname='.$initialValues['dbname'];
    while (!isset($_POST['username']) || validateUsernamePassword($_POST['username'], $_POST['password'], $dsn, $initialValues['user'], $initialValues['password'] )) {
        include $_SERVER['DOCUMENT_ROOT'] . $initialValues['html'] . '/autorization.html.php';
    }
