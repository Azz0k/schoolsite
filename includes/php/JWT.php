<?php

//в отличие от рфц, будем делать без header(зачем давать лишнюю инфу?) подпись будет sha512
class JWT
{
  private $username;
  private $secret;
  private $payload;
  public static $rights;
  public function __construct($username, $secret)
  {
    $this->username = $username;
    $this->secret = $secret;

    //надо переделать на такую схему: <изменяемая часть - время здесь>.<неизменяемая часть - здесь права и имя пользователя>.<подпись>
  }

  public function generate(){
    $MAIN_INI_FILE = $_SERVER['DOCUMENT_ROOT'] . '/init.ini';
    $initialValues = parse_ini_file($MAIN_INI_FILE, false, INI_SCANNER_TYPED);
    $database = new Database($initialValues);
    //$payload_array = ["username"=>$this->username,"group"=>"superuser","exp"=>$exp, "canregen"=>$canregen];
    $user = $database->findUser($this->username);
    $immutablePayloadArray = ["username"=>$this->username, "Configuration"=>$user['canconfigure'], "Users"=>$user['canchangeusers'], "Menu"=>$user['canchangemenu'], "Materials"=>$user['canchangematerials']];
    $immutablePayload = base64_encode(json_encode($immutablePayloadArray));
    return $this->regenerate($immutablePayload);
  }
  public function regenerate($immutablePayload) {
    $exp = time()+8*60*60;
    $canregen = time()+60*60;
    $mutablePayloadArray = ["exp"=>$exp, "canregen"=>$canregen];
    $mutablePayload = base64_encode(json_encode($mutablePayloadArray));
    $needToHash = $mutablePayload.'.'.$immutablePayload;
    return $needToHash.'.'.hash_hmac('sha512',$needToHash, $this->secret);
  }
  //проверяет, валидный ли ключ. Если валидный: если можно обновить, обновляет (возвращает новый). Если рано, возвращает старый (валидный). Если не валидный - возвращает false
  public static function validate($jwt, $secret){
      list($mutablePayload,$immutablePayload, $hash) = explode('.',$jwt);
      $payload = $mutablePayload.'.'.$immutablePayload;
      $new_hash = hash_hmac('sha512',$payload, $secret);
      if ($hash===$new_hash){// подпись валидна
        $payload = json_decode(base64_decode($mutablePayload));
        self::$rights = json_decode(base64_decode($immutablePayload));
        $time = $payload->exp;//проверить не старый ли, проверить на возможность обновления
        if ($time > time()) {
          $time = $payload->canregen;
            if ($time > time()) return $jwt;
            else{
              $instance = new self(self::$rights['username'], $secret);
              return $instance->regenerate($immutablePayload);
            }

        }
      }
      return false;
  }
}
