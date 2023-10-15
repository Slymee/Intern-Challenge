<?php
include('APIFetch.php');

include('DatabaseSelect.php');
$apiURL="https://raw.githubusercontent.com/younginnovations/internship-challenges/master/programming/petroleum-report/data.json";

$apiFetch= new APIFetch($apiURL);
// echo $apiFetch->displayURL();
$apiFetch->displayJson();
echo "<br>";
echo "<h1>Contents of Database</h1><br>";


$dbOpe = new DatabaseSelect("petroleum_data.db");

$dbOpe->displayYearsTable();
$dbOpe->displayProductsTable();
$dbOpe->displayCountryTable();
$dbOpe->displaySalesTable();


$dbOpe->displayEachProductTotal();

$dbOpe->displayThreeHighestSaleCountry();

$dbOpe->displayThreeLowestSaleCountry();

$dbOpe->averageFourYearInvervalSale();







?>