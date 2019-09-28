<?php
foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/includes/php/*.php') as $file) {
  require_once $file;
}
$MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
$initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);
//$testJson = ["jsonrpc"=>"2.0", "method"=>"Users.getAll"];
//$data = json_decode(json_encode($testJson),true);
$testJson = '{"jsonrpc":"2.0","method":"Users.update","params":[{"id":2,"firstname":"pavel","lastname":"milokum","email":"11@11.ru","description":null,"userdate":"2019-08-16","username":"pmilokum","canconfigure":1,"canchangeusers":1,"canchangemenu":1,"canchangematerials":1,"deleted":0,"enabled":1},{"id":3,"firstname":"first","lastname":"last","email":"test@test.ru","description":"test user","userdate":"2019-09-14","username":"test","canconfigure":0,"canchangeusers":0,"canchangemenu":0,"canchangematerials":0,"deleted":0,"enabled":0}],"id":"Users.getAll"}';
$data = json_decode($testJson,true);
$database = new Database($initialValues);
$jsonRpc = new JsonRpc($data, (object) ["Users"=>1], $database);
echo $jsonRpc->getResponse();
