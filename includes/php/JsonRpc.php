<?php


class JsonRpc
{
  private $pdo;
  private $rights;
  private $request;

  public function __construct($request, $rights, $pdo) {
    $this->request = $request;
    $this->rights = $rights;
    $this->pdo = $pdo;
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

  private function arrayToJson($arr, $id){
    $result = ["jsonrpc" => "2.0", "result"=>$arr, "id" => $id];
    return json_encode($result);
  }

  public function getResponse() {
    if ($this->request["jsonrpc"]!=="2.0")
      return $this->errorToJson(-32700);
    list($category, $method) = explode('.', $this->request["method"]);
    switch ($category){
      case 'Users':
          if ($this->rights->Users === 0)
            return $this->errorToJson(-1);
          if ($method === "getAll"){
            $users = $this->pdo->findUser('', true);
            for ($i=0;$i<count($users);$i++){
              unset($users[$i]['password']);
            }
            return $this->arrayToJson($users, "Users.getAll");
          }

        break;
      default:
        return $this->errorToJson(-32601);

    }
  }
}
