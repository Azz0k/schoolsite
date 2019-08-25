<?php


class Database
{
    private $dsn;
    private $username;
    private $password;
    private $pdo;

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
    public function findUser($username){
        $result = null;
        try{
            //$result = $this->pdo->query("select  from users where username='$username'");
            $pdo = $this->pdo;
            $s = $pdo->prepare('select * from users where username=:name');
            $s->bindValue(':name', $username);
            $s->execute();
            $result = $s->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            $this->error($e, "Unable to query database: ");
            exit(0);
        }

        return $result;
    }
    //новая функция для APi
    public function validateUserName($username, $password, $newtoken, $oldtoken){
      if ($oldtoken===$newtoken){
        $pattern = '/^[\w\-\_\.]+$/'; //username can contain only letters, numbers, dots, -_
        if (!preg_match($pattern, $username)) return false;
        $user = $this->findUser($username);
        if (password_verify($password, $user['password'])) return true;
      }
      return false;
    }

    // проверяет, есть ли юзер в бд
    public function validateUserPassword($token){
        if ($token ===$_POST['csrftoken']){
            $pattern = '/^[\w\-\_\.]+$/'; //username can contain only letters, numbers, dots, -_
            if (!preg_match($pattern, $_POST['username'])) return false;
            $user = $this->findUser($_POST['username']);
            if (password_verify($_POST['password'],$user['password']))//($user['password']===$_POST['password'])
                return true;
        }
        return false;
    }

    public function storeCookie($username, $hash){
        try{
            $pdo = $this->pdo;
            $s = $pdo->prepare('update users set cookie=:cookie where username=:name');
            $s->bindValue(':name', $username);
            $s->bindValue(':cookie', $hash);
            $s->execute();
        }
        catch (PDOException $e){
            $this->error($e, "Unable to query database: ");
            exit(0);
        }
    }
    public function validateCookie($username, $hash){
        try{
            $pdo = $this->pdo;
            $s = $pdo->prepare('select * from users where username=:name');
            $s->bindValue(':name', $username);
            $s->execute();
            $result = $s->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e){
            $this->error($e, "Unable to query database: ");
            exit(0);
        }
        if ($result['cookie']===$hash) return true;
        return false;
    }
}
