<?php
function getToken($length){
    $token = openssl_random_pseudo_bytes($length);
    $token = substr(bin2hex($token), 0, $length);
    return $token;
}