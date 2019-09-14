<?php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/components/testheaders.php';

$database = new Database($initialValues);
$users = $database->findUser('*', true);
for ($i=0;$i<count($users);$i++){
  unset($users[$i]['password']);
}
echo json_encode($users);

die();


