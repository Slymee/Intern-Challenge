<style>
    table,th,td{
        border: 1px solid black;
        border-collapse: collapse;

    }
</style>


<?php
    include('DatabaseOperation.php');
?>




<?php
class APIFetch{
    private $url;

    public function displayURL(){
        return $this->url;
    }

    //setting API URL
    public function __construct($url){
        $this->url=$url;
    }

    //retrive API Data
    public function apiDataFetch(){
        $curlInit=curl_init($this->url);

        //cURL option set
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

        // $result=curl_exec($curlInit);
        if(curl_exec($curlInit)===false){
            die("Data fetch failed:  ". curl_error($curlInit));
        }

        curl_close($curlInit);
        return curl_exec($curlInit);

    }

    //retrive json data
    public function jsonData(){
        return json_decode($this->apiDataFetch(), true); 
    }

    
    public function displayJson(){

        try{
        //create database 
        $dbObject = new DatabaseOperate("petroleum_data.db");
        $dbObject->createTable();

        $data = $this->jsonData();?>
        <h1>Data from API</h1>
        <table>
            <tr>
                <th>Year</th>
                <th>Petroleum Product</th>
                <th>Sale</th>
                <th>Country</th>
            </tr>
        <?php



        foreach($data as $item){?>
            <tr>
                <td><?php echo $item['year'];?></td>
                <td><?php echo $item['petroleum_product'];?></td>
                <td><?php echo $item['sale'];?></td>
                <td><?php echo $item['country'];?></td>
            </tr>

        <?php 
            // $year=$item['year'];
            // $product=$item['petroleum_product'];
            // $sale=$item['sale'];
            // $country=$item['country'];

            $dbObject->databaseStore($item['year'],$item['petroleum_product'],$item['country'],$item['sale']);
            
        
        
        }

        ?>
        </table><?php
        $dbObject->closeConnection();
        }catch(Exception $e){
            die("Exception caught: ". $e->getMessage());
        }
    }
    
    
    
}

?>