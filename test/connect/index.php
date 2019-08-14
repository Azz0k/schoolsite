<?php
//include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.inc.php';
include_once 'includes/db.inc.php';
include_once 'includes/htmlout.inc.php';
include_once 'includes/query.inc.php';

    if (isset($_GET['addjoke'])){
        include 'addjoke.html.php';
        die();
    }
    $dsn = 'mysql:host=localhost;dbname=ijdb';
    $user = 'ijdb';
    $pass = 'gW3DYkj6NFRmEwQpf7D5';
    if (!isset($pdo)){
        $pdo = connectToDB($dsn, $user, $pass);
    }
    try{
        if (isset($_POST['joketext'])){
        //date https://www.php.net/manual/en/function.date.php
        $date = date('o-m-j');
        //safe insert https://www.php.net/manual/en/pdo.prepared-statements.php
        $stmt = $pdo->prepare("insert into joke (joketext, jokedata) values (:text, :date)");
        $stmt->bindParam(':text', $_POST['joketext']);
        $stmt->bindParam(':date', $date);
        //$sql = 'insert into joke set joketext=" '.$_POST['joketext'].'", jokedata="'.$date.'"';
        $stmt->execute();
        //$pdo->exec($sql);
        header('Location: .');
        die();
    }
}
catch (PDOException $e){
    $output = "Unable to insert to database: ".$e->getMessage();
    include "error.html.php";
    exit();
}
    if (isset($_POST['deljoke'])) {
        try {
            $stmt_del = $pdo->prepare('delete from joke where id=:id');
            $stmt_del->bindParam(':id', $_POST['deljoke']);
            $stmt_del->execute();
            header('Location: .');

        } catch (PDOException $e) {
            $output = "Unable to delete from database: " . $e->getMessage();
            include "error.html.php";

        }
        exit();
    }
    $sql = "select joke.id, joketext, name, email from joke inner join author where authorid=author.id";
    $result = queryDb($pdo, $sql);
        include "output.html.php";
