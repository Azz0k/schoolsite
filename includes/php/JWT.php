<?php

//в отличие от рфц, будем делать без header(зачем давать лишнюю инфу?) подпись будет sha512
class JWT
{
  private $username;
  private $secret;
  private $payload;
  public function __construct($username, $secret)
  {
    $this->username = $username;
    $this->secret = $secret;
    //временно, потом будем права прописывать из таблицы.
    //$payload_array = ["username"=>$username,"group"=>"superuser","exp"=>(+time()+8*60), "canregen"=>(+time()+60)];
    //$this->payload = base64_encode(json_encode($payload_array));
  }

  public function generate(){
    $exp = time()+8*60*60;
    $canregen = time()+60*60;
    $payload_array = ["username"=>$this->username,"group"=>"superuser","exp"=>$exp, "canregen"=>$canregen];
    $this->payload = base64_encode(json_encode($payload_array));
    return $this->payload.'.'.hash_hmac('sha512',$this->payload, $this->secret);
  }
  //проверяет, валидный ли ключ. Если валидный: если можно обновить, обновляет (возвращает новый). Если рано, возвращает старый (валидный). Если не валидный - возвращает null
  public static function validate($jwt, $secret){
      list($payload, $hash) = explode('.',$jwt);
      $new_hash = hash_hmac('sha512',$payload, $secret);
      if ($hash===$new_hash){// подпись валидна
        $payload = json_decode(base64_decode($payload));
        $time = $payload->exp;//проверить не старый ли, проверить на возможность обновления
        if ($time > time()) {
          $time = $payload->canregen;
            if ($time > time()) return $jwt;
            else{
              $username = $payload->username;
              $instance = new self($username, $secret);
              return $instance->generate();
            }

        }
      }
      return null;
  }
}
