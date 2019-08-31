<?php

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

if ($method==="GET"){
  $header = getallheaders();
  if (isset($header['Authorization']) && $header['Authorization']){
    $jwt = $header['Authorization'];
    //тут надо запилить проверку jwt и перевыпуск токена
  }
  else {
    $cookiehash = getToken(250);
    setcookie('csrf', $cookiehash, 0, '/', '', false, true);//cookie expires after browser closed
    http_response_code(200);
    echo json_encode(array("csrf" => $cookiehash));
    die();
  }
}
else {
  $data = json_decode(file_get_contents("php://input"));
  $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
  $initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);
  $database = new Database($initialValues);
  if ($database->validateUserName($data->username, $data->password, $data->csrf, $_COOKIE['csrf'])) {
    http_response_code(200);
    $jwt = new JWT($data->username, $initialValues['secret']);
    echo json_encode(array("message" => "Authorized","jwt"=>$jwt->generate()));
  } else {
    http_response_code(401);
    echo json_encode(array("message" => "Not authorized"));
  }
}
