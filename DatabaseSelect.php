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
    }
?>