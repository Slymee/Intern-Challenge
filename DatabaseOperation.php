<?php
class DatabaseOperate{
    private $dbName;
    private $dbStatement;
    function __construct($dbName){
        try{
            $this->dbName=$dbName;
            $this->dbStatement = new PDO('sqlite:'. $dbName);
            // echo "<script>console.log('DB created')</script>";
        }catch(PDOException $e){
            die("Database creation failed: ". $e->getMessage());
        }
    }

    function createTable(){
        try{
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `years` (`y_id` INTEGER PRIMARY KEY AUTOINCREMENT, `year` TEXT)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `products` (`p_id` INTEGER PRIMARY KEY AUTOINCREMENT, `p_name` TEXT)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `countries` (`c_id` INTEGER PRIMARY KEY AUTOINCREMENT, `c_name` TEXT)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `sales` (`sale_id` INTEGER PRIMARY KEY AUTOINCREMENT, `y_id` INTEGER, `p_id` INTEGER, `sale` INTEGER, `c_id` INTEGER, FOREIGN KEY(`y_id`) REFERENCES `years`(`y_id`), FOREIGN KEY(`p_id`) REFERENCES `products`(`p_id`), FOREIGN KEY(`c_id`) REFERENCES `countries`(`c_id`))");
                
        }catch(Exception $e){
            die("Table creation failed: ". $e->getMessage());
        }
    }

    function databaseStore($year, $product, $country, $sale){
        $yearId=$this->getOrCreateId('years', 'year', $year, 'y_id');

        $productId=$this->getOrCreateId('products', 'p_name', $product, 'p_id');

        $countryId=$this->getOrCreateId('countries', 'c_name', $cpuntry, 'c_id');

        $saleId = $this->getSaleId($yearId, $productId, $countryId);
        
    }

    function getOrCreateId($table, $column, $data, $primeKey){

    }

    function getSaleId($yearId, $productId, $countryId){
        
    }
}
?>