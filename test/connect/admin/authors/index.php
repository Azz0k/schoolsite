<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/test/connect/includes/db.inc.php';

    include_once $_SERVER['DOCUMENT_ROOT'].'/test/connect/includes/htmlout.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/test/connect/includes/query.inc.php';

    $dsn = 'mysql:host=localhost;dbname=ijdb';
    $user = 'ijdb';
    $pass = 'gW3DYkj6NFRmEwQpf7D5';
    if (!isset($pdo)) {
        $pdo = connectToDB($dsn, $user, $pass);
    }
    if (isset($_POST['name']) && isset($_POST['email'])) {
        try {

            //date https://www.php.net/manual/en/function.date.php

            //safe insert https://www.php.net/manual/en/pdo.prepared-statements.php
            $stmt = $pdo->prepare("insert into author (name, email) values (:name, :email)");
            $stmt->bindParam(':name', $_POST['name']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->execute();
            header('Location: .');
            die();
        } catch (PDOException $e) {
            $output = "Unable to insert to database: " . $e->getMessage();
            include "error.html.php";
            exit();
        }
    }
    $sql = 'select id, name, email from author';
    $result = queryDb($pdo, $sql);
    include 'authors.html.php';