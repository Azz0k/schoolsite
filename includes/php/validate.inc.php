<?php
function validateUsernamePassword($username, $password, $dsn, $dbusername, $dbpassword){
    $pdo = connectToDB($dsn, $dbusername, $dbpassword);
    return false;
}
