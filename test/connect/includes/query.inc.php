<?php
    function queryDb($pdo, $sql){
        try{

            $result = $pdo->query($sql);
        }
        catch (PDOException $e){
            $output = "Unable to insert to database: ".$e->getMessage();
            include_once $_SERVER['DOCUMENT_ROOT']."error.html.php";
            exit();
        }
        return $result;
    }