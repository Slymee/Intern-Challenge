<?php
class DatabaseOperate{
    function __construct(){

    }

    function createDatabase($dbName){
        try{
            $db = new PDO('sqlite:'. $dbName);
            echo "<script>console.log('DB created')</script>";
        }catch(PDOException $e){
            die("Database creation failed: ". $e->getMessage());
        }
    }
}
?>