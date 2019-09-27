<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/components/headers.php';
if (JWT::$rights->Users ===0){
  http_response_code(403);
  die();
}
$database = new Database($initialValues);
$users = $database->findUser('', true);
$newUsers = json_decode(file_get_contents("php://input"));
//$temp = array_diff($newUsers, $users);
$result = $database->updateUsers($newUsers, $users);
if ($result){
  http_response_code(200);
}
else{
  http_response_code(501);
}
