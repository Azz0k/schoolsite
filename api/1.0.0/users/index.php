<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/components/headers.php';
if (JWT::$rights['canchangeusers']===0){
  http_response_code(403);
  die();
}
$database = new Database($initialValues);
$users = $database->findUser('', true);
for ($i=0;$i<count($users);$i++){
  unset($users[$i]['password']);
}
echo json_encode($users);
die();

