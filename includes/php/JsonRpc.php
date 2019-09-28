<?php


class JsonRpc
{
  private $database;
  private $rights;
  private $request;

  public function __construct($request, $rights, $database) {
    $this->request = $request;
    $this->rights = $rights;
    $this->database = $database;
  }

  private function errorToJson($error, $message='') {
    $errorCodes = [
      -1=>"Insufficient rights",
      -32700=>"Parse error",
      -32600=>"Invalid Request",
      -32601=>"Method not found",
      -32602=>"Invalid params",
      -32603=>"Internal error"
    ];
    if (isset($errorCodes[$error]))
      $resultMessage=$errorCodes[$error];
    else
      $resultMessage = $message;

    $result = ["jsonrpc" => "2.0", "error"=>["code"=>$error, "message"=>$resultMessage], "id" => null];
    return json_encode($result);
  }

  private function resultToJson($arr, $id = null){
    $result = ["jsonrpc" => "2.0", "result"=>$arr, "id" => $id];
    return json_encode($result);
  }

  private function getAllUsers() {
    $users = $this->database->findUser('', true);
    for ($i=0;$i<count($users);$i++){
      unset($users[$i]['password']);
    }
    return $users;
  }
  public function getResponse() {
    if ($this->request["jsonrpc"]!=="2.0")
      return $this->errorToJson(-32700);
    list($category, $method) = explode('.', $this->request["method"]);
    $params = $this->request["params"];
    $id = $this->request["id"];
    switch ($category){
      case 'Users':
          if ($this->rights->Users === 0)
            return $this->errorToJson(-1);
          if ($method === "getAll"){
            return $this->resultToJson($this->getAllUsers(), "Users.getAll");
          }
          if ($method === "update") {
            $this->database->updateUsers($params);
            return $this->resultToJson($this->getAllUsers(), "Users.update");
          }
          if ($method === "add") {
            $this->database->updateUsers($params,'ADD');
            return $this->resultToJson($this->getAllUsers(), "Users.update");
          }
          if ($method === "changePassword") {
            $pass = array(array("id"=>$id,"password"=>password_hash($params, PASSWORD_DEFAULT)));
            $this->database->updateUsers($pass,'PASSWORD');
            return $this->resultToJson("ok", $id);
          }
        break;
      default:
        return $this->errorToJson(-32601);

    }
  }
}
