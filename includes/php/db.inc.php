<?php
function connectToDB($dsn, $user, $passwd)
{


    try {
        $pdo = new PDO($dsn, $user, $passwd);
        //$pdo = new PDO('mysql:host=localhost;dbname=ijdb', 'ijdb', 'gW3DYkj6NFRmEwQpf7D5');
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        $error = "Unable to connect to database: " . $e->getMessage();
        include "error.html.php";
        exit();
    }
    return $pdo;
}
