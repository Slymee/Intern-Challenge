<?php
    class DatabaseSelect{
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

        function displayYearsTable(){
            echo "<h2>Years Table</h2>";

            $stmt = $this->dbStatement->prepare("SELECT * FROM years");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Year</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['y_id'];?></td>
                        <td><?php echo $row['year'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }



        function displayProductsTable(){
            echo "<h2>Products Table</h2>";

            $stmt = $this->dbStatement->prepare("SELECT * FROM products");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['p_id'];?></td>
                        <td><?php echo $row['p_name'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


        function displayCountryTable(){
            echo "<h2>Country Table</h2>";

            $stmt = $this->dbStatement->prepare("SELECT * FROM countries");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Country</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['c_id'];?></td>
                        <td><?php echo $row['c_name'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


        function displaySalesTable(){
            echo "<h2>Sales Table</h2>";

            $stmt = $this->dbStatement->prepare("SELECT * FROM sales");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>Sale ID</th>
                    <th>Year ID</th>
                    <th>Product ID</th>
                    <th>Sale</th>
                    <th>Country ID</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['sale_id'];?></td>
                        <td><?php echo $row['y_id'];?></td>
                        <td><?php echo $row['p_id'];?></td>
                        <td><?php echo $row['sale'];?></td>
                        <td><?php echo $row['c_id'];?></td>
                        
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


        function displayEachProductTotal(){
            echo "<h2>Total sale of each Product</h2>";

            $stmt = $this->dbStatement->prepare("SELECT `p_name`, SUM(`sale`) as sum FROM `sales` JOIN `products` ON `sales`.`p_id` = `products`.`p_id` GROUP BY `p_name`");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Total Sale</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['p_name'];?></td>
                        <td><?php echo $row['sum'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


        function displayThreeHighestSaleCountry(){
            echo "<h2>Three Highest Sale Counties</h2>";

            $stmt = $this->dbStatement->prepare("SELECT `c_name`, SUM(`sale`) as sum FROM `sales` JOIN `countries` ON `sales`.`c_id` = `countries`.`c_id` GROUP BY `c_name` ORDER BY `sum` DESC LIMIT 3");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>Country</th>
                    <th>Total Sale</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['c_name'];?></td>
                        <td><?php echo $row['sum'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


        function displayThreeLowestSaleCountry(){
            echo "<h2>Three Lowest Sale Counties</h2>";

            $stmt = $this->dbStatement->prepare("SELECT `c_name`, SUM(`sale`) as sum FROM `sales` JOIN `countries` ON `sales`.`c_id` = `countries`.`c_id` GROUP BY `c_name` ORDER BY `sum` ASC LIMIT 3");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>Country</th>
                    <th>Total Sale</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['c_name'];?></td>
                        <td><?php echo $row['sum'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }

        function averageFourYearInvervalSale(){
            echo "<h2>Average Sale Four Year Interval</h2>";

            $stmt = $this->dbStatement->prepare("SELECT
            p_name,
            CASE
                WHEN CAST(year AS INTEGER) BETWEEN 2007 AND 2011 THEN '2007-2011'
                WHEN CAST(year AS INTEGER) BETWEEN 2012 AND 2014 THEN '2012-2014'
                ELSE 'Other'
            END as [Interval],
            AVG(sale) as Average
        FROM
            (SELECT
                p_name,
                year,
                sale
            FROM
                sales
            JOIN
                products ON sales.p_id = products.p_id
            JOIN
                years ON sales.y_id = years.y_id
            WHERE
                sale > 0
            AND
                CAST(year AS INTEGER) BETWEEN 2007 AND 2014) AS filtered_data
        GROUP BY
            p_name, [Interval]
        ORDER BY
            p_name, [Interval];
        ");
            $stmt->execute();
            ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Interval</th>
                    <th>Average</th>
                </tr>
                <?php
                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['p_name'];?></td>
                        <td><?php echo $row['Interval'];?></td>
                        <td><?php echo $row['Average'];?></td>
                    </tr>
                  
                <?php
                }
                ?>
            </table>
        <?php
        }


    }
?>