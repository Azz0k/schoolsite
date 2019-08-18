<?php
function openLoginForm($initialValues, $isFirst=true){
    $invalidFeedback = '';
    if (!$isFirst){
        $invalidFeedback = 'Неправильное имя <br>пользователя или пароль';
    }
    $csrfToken = getToken(32);
    $_SESSION['csrfToken'] = $csrfToken;
    include $_SERVER['DOCUMENT_ROOT'] . $initialValues['html'] . '/autorization.html.php';
    exit();
}
