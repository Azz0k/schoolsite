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
    $payload_array = ["username"=>$username,"group"=>"superuser","exp"=>(+time()+8*60)]; //временно, потом будем права прописывать из таблицы.
    $this->payload = base64_encode(json_encode($payload_array));
  }
  public function generate(){
    return $this->payload.'.'.hash_hmac('sha512',$this->payload, $this->secret);
  }
}
