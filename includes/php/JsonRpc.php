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

  private function arrayToJson($arr, $id = null){
    $result = ["jsonrpc" => "2.0", "result"=>$arr, "id" => $id];
    return json_encode($result);
  }

  public function getResponse() {
    if ($this->request["jsonrpc"]!=="2.0")
      return $this->errorToJson(-32700);
    list($category, $method) = explode('.', $this->request["method"]);
    $params = $this->request["params"];
    switch ($category){
      case 'Users':
          if ($this->rights->Users === 0)
            return $this->errorToJson(-1);
          if ($method === "getAll"){
            $users = $this->database->findUser('', true);
            for ($i=0;$i<count($users);$i++){
              unset($users[$i]['password']);
            }
            return $this->arrayToJson($users, "Users.getAll");
          }
          if ($method === "update") {
            if ($this->database->updateUsers($params)) return $this->arrayToJson(["result"=>"ok"]);
            else $this->errorToJson(-32602);
          }
        break;
      default:
        return $this->errorToJson(-32601);

    }
  }
}
