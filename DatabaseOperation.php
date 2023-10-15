<?php
class DatabaseOperate{
    private $dbName;
    private $dbStatement;
    function __construct($dbName){
        try{
            $this->dbName=$dbName;
            $this->dbStatement = new PDO('sqlite:'. $dbName);
            $this->dbStatement->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "<script>console.log('DB created')</script>";
        }catch(PDOException $e){
            die("Database creation failed: ". $e->getMessage());
        }
    }

    function createTable(){
        try{
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `years` (`y_id` INTEGER PRIMARY KEY AUTOINCREMENT, `year` VARCHAR)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `products` (`p_id` INTEGER PRIMARY KEY AUTOINCREMENT, `p_name` VARCHAR)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `countries` (`c_id` INTEGER PRIMARY KEY AUTOINCREMENT, `c_name` VARCHAR)");
            $this->dbStatement->exec("CREATE TABLE IF NOT EXISTS `sales` (`sale_id` INTEGER PRIMARY KEY AUTOINCREMENT, `y_id` INTEGER, `p_id` INTEGER, `sale` INTEGER, `c_id` INTEGER, FOREIGN KEY(`y_id`) REFERENCES `years`(`y_id`), FOREIGN KEY(`p_id`) REFERENCES `products`(`p_id`), FOREIGN KEY(`c_id`) REFERENCES `countries`(`c_id`))");
                
        }catch(Exception $e){
            die("Table creation failed: ". $e->getMessage());
        }
    }

    function checkYearExist($year){
        $stmt = $this->dbStatement->prepare("SELECT * FROM years WHERE [year] = :year");
        $stmt->bindParam(':year', $year, PDO::PARAM_STR);
            
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            return $data??false;
        } else {
            throw new Exception();
        }
    }

    function checkProductExist($product){
        $stmt=$this->dbStatement->prepare("SELECT * FROM products WHERE p_name= :product");
        $stmt->bindParam(':product', $product, PDO::PARAM_STR);
        
        
        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            // var_dump($data);
            return $data??false;
        } else {
            throw new Exception();
        }
    }

    function checkCountryExist($country){

            $stmt=$this->dbStatement->prepare("SELECT * FROM countries WHERE c_name= :country");
            $stmt->bindParam(':country', $country, PDO::PARAM_STR);
            
            
            if ($stmt->execute()) {
                $data = $stmt->fetchAll();
                // var_dump($data);
                return $data??false;
            } else {
                throw new Exception();
            }
    }


    function getSaleExist($year, $product, $country){
        $yearIdSelect=$this->dbStatement->prepare("SELECT y_id FROM years WHERE [year] = :_year");
        $yearIdSelect->bindParam(':_year', $year, PDO::PARAM_STR);
        $yearIdSelect->execute();
        $yearId=$yearIdSelect->fetchColumn();

        $productIdSelect=$this->dbStatement->prepare("SELECT p_id FROM products WHERE p_name = :_product");
        $productIdSelect->bindParam(':_product', $product, PDO::PARAM_STR);
        $productIdSelect->execute();
        $productId=$productIdSelect->fetchColumn();

        $countryIdSelect=$this->dbStatement->prepare("SELECT c_id FROM countries WHERE c_name = :_country");
        $countryIdSelect->bindParam(':_country', $country, PDO::PARAM_STR);
        $countryIdSelect->execute();
        $countryId=$countryIdSelect->fetchColumn();


        $stmt=$this->dbStatement->prepare("SELECT * FROM sales WHERE y_id = :yearId AND p_id = :productId AND c_id = :countryId");
        $stmt->bindParam(':yearId', $yearId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':countryId', $countryId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $data = $stmt->fetchAll();
            // var_dump($data);
            return $data??false;
        }else{
            throw new Exception();
        }
    }

    function databaseStore($year, $product, $country, $sale){
        $yearId=null;
        $productId=null;
        $countryId=null;
        $saleId=null;

        try{
            if(!($this->checkYearExist($year))){
                $this->dbStatement->exec("INSERT INTO `years` (`year`) VALUES ('$year')");
                // $stmt=$this->dbStatement->prepare("SELECT y_id FROM years WHERE [year] = :_year");
                // $stmt->bindParam(':_year', $year, PDO::PARAM_STR);
                // $stmt->execute();
                // $yearID=$stmt->fetchColumn();
                // var_dump($yearID);
            }

    
            if(!($this->checkProductExist($product))){
                $this->dbStatement->exec("INSERT INTO `products` (`p_name`) VALUES ('$product')");
                // $stmt=$this->dbStatement->prepare("SELECT p_id FROM products WHERE p_name = :product");
                // $stmt->bindParam(':product', $product, PDO::PARAM_STR);
                // $stmt->execute();
                // $productID=$stmt->fetchColumn();
                // var_dump($productID);
            }

    
            if(!($this->checkCountryExist($country))){
                $this->dbStatement->exec("INSERT INTO `countries` (`c_name`) VALUES ('$country')");
                // $stmt=$this->dbStatement->prepare("SELECT c_id FROM countries WHERE c_name = :country");
                // $stmt->bindParam(':country', $country, PDO::PARAM_STR);
                // $stmt->execute();
                // $countryID=$stmt->fetchColumn();
                // var_dump($countryID);
            }
    
            if(!($this->getSaleExist($year,$product,$country))){
                $yearIdSelect=$this->dbStatement->prepare("SELECT y_id FROM years WHERE [year] = :_year");
                $yearIdSelect->bindParam(':_year', $year, PDO::PARAM_STR);
                $yearIdSelect->execute();
                $yearId=$yearIdSelect->fetchColumn();

                $productIdSelect=$this->dbStatement->prepare("SELECT p_id FROM products WHERE p_name = :_product");
                $productIdSelect->bindParam(':_product', $product, PDO::PARAM_STR);
                $productIdSelect->execute();
                $productId=$productIdSelect->fetchColumn();

                $countryIdSelect=$this->dbStatement->prepare("SELECT c_id FROM countries WHERE c_name = :_country");
                $countryIdSelect->bindParam(':_country', $country, PDO::PARAM_STR);
                $countryIdSelect->execute();
                $countryId=$countryIdSelect->fetchColumn();

                $stmt=$this->dbStatement->prepare("INSERT INTO `sales` (`y_id`, `p_id`, `sale`, `c_id`) VALUES (:yearId, :productId, :sale, :countryId)");
                $stmt->bindParam(':yearId', $yearId, PDO::PARAM_INT);
                $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':sale', $sale, PDO::PARAM_STR);
                $stmt->bindParam(':countryId', $countryId, PDO::PARAM_INT);
                $stmt->execute();
            }
            
        }catch(Exception $e){
            die("Exception: ". $e->getMessage());
        }



        
    }

    function closeConnection(){
        $this->dbStatement=null;
    }

    
}
?>