<?php

#header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Access-Control-Allow-Credentials");
$method = $_SERVER['REQUEST_METHOD'];
if ($method==='OPTIONS'){
  http_response_code(200);
  die();
}

foreach (glob($_SERVER['DOCUMENT_ROOT'].'/includes/php/*.php') as $file){
  require_once $file;
}
if ($method !== "GET"){
  http_response_code(403);
  die();
}
$header = getallheaders();
if (!isset($header['Authorization']) && !$header['Authorization']){
  http_response_code(401);
  die();
}
list($bearer,$oldJwt) = explode(' ',$header['Authorization']);
if ($bearer!=='Bearer'){
  http_response_code(401);
  die();
}
  $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
  $initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);
  $jwt = JWT::validate($oldJwt, $initialValues['secret']);
  if (!$jwt) {
    http_response_code(401);
    die();
  }
  http_response_code(200);


