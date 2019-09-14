<?php


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

$header = getallheaders();

$MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
$initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);




