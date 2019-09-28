<?php


class Database
{
    private $dsn;
    private $username;
    private $password;
    private $pdo;
    private $currentUser;

    //Конструктор
    public function __construct($ini)
    {
        $this->pdo = null;
        $this->dsn = $ini['base'].':host='.$ini['host'].';dbname='.$ini['dbname'];
        $this->username = $ini['user'];
        $this->password = $ini['password'];
        $this->connect();
    }
    //Обработка ошибок
    private function error($e, $message){
        $error = $message . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT']."/error.html.php";
        exit();
    }
    //соединение с базой
    public function connect(){
        try {
            $pdo = new PDO($this->dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch (PDOException $e) {
            $this->error($e, "Unable to connect database: ");
        }
        $this->pdo = $pdo;
        //return $pdo;
    }
    //запрос из базы
    public function findUser($username, $all = false){
        $result = null;
        try{
            $pdo = $this->pdo;
            if ($all){
              $s = $pdo->prepare('select * from users');
              $s->execute();
              $result = $s->fetchAll(PDO::FETCH_ASSOC);
            }else
            {
              $s = $pdo->prepare('select * from users where username=:name');
              $s->bindValue(':name', $username);
              $s->execute();
              $result = $s->fetch(PDO::FETCH_ASSOC);
            }
        }
        catch (PDOException $e){
            $this->error($e, "Unable to query database: ");
            exit(0);
        }
        return $result;
    }

    public function updateUsers($newUsers, $method = 'UPDATE') {
      $result = true;
      $update = null;
      try{
        //$update = $this->pdo->prepare('UPDATE users SET firstname=:firstname lastname=:lastname email=:email description=:description username=:username canconfigure=:canconfigure canchangeusers=:canchangeusers canchangemenu=:canchangemenu canchangematerials=:canchangematerials deleted=:deleted enabled=:enabled WHERE id=:id');
        if ($method === 'UPDATE'){
          $update = $this->pdo->prepare('UPDATE users SET userdate=:userdate, firstname=:firstname, lastname=:lastname, email=:email, description=:description, username=:username, canconfigure=:canconfigure, canchangeusers=:canchangeusers, canchangemenu=:canchangemenu, canchangematerials=:canchangematerials, deleted=:deleted, enabled=:enabled WHERE id=:id');
        }
        if ($method === 'ADD') {
          $update = $this->pdo->prepare('INSERT INTO users SET userdate=:userdate, firstname=:firstname, lastname=:lastname, email=:email, description=:description, username=:username, canconfigure=:canconfigure, canchangeusers=:canchangeusers, canchangemenu=:canchangemenu, canchangematerials=:canchangematerials, deleted=:deleted, enabled=:enabled, id=:id');
        }
        foreach ($newUsers as $newUser){
          $newUser["userdate"]=date ("Y-m-d H:i:s");
          $update->execute($newUser);
        }
      }
      catch (PDOException $e){
        $result=false;
      }
      return $result;
    }



    //новая функция для APi возвращает true если совпадает два токена и в базе есть юзер с паролем
    public function validateUserName($username, $password, $newtoken, $oldtoken){
      if ($oldtoken===$newtoken){
        $pattern = '/^[\w\-\_\.@]+$/'; //username can contain only letters, numbers, dots, -_@
        if (!preg_match($pattern, $username)) return false;
        $user = $this->findUser($username, false);
        //if ($user['deleted']===1 || $user['enabled']===0) return false;
        if (password_verify($password, $user['password'])) return true;
      }
      return false;
    }


}
