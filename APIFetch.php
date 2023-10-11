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
        return $result;

    }

    //retrive json data
    public function jsonData(){
        return json_decode($this->apiDataFetch(), true);
    }
}

?>