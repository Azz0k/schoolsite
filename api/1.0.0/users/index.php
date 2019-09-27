<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/components/headers.php';
if (JWT::$rights->Users ===0){
  http_response_code(403);
  die();
}
$database = new Database($initialValues);
$users = $database->findUser('', true);
for ($i=0;$i<count($users);$i++){
  unset($users[$i]['password']);
}
http_response_code(200);
echo json_encode($users);
die();

