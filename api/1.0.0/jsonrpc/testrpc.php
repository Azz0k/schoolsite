<?php
foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/includes/php/*.php') as $file) {
  require_once $file;
}
$MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
$initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);
$testJson = ["jsonrpc"=>"2.0", "method"=>"Users.getAll"];
$data = json_decode(json_encode($testJson),true);
$database = new Database($initialValues);
$jsonRpc = new JsonRpc($data, (object) ["Users"=>1], $database);
echo $jsonRpc->getResponse();
