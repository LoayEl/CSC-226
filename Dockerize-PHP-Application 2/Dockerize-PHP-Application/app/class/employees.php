<?php
    class Phone{

        // Connection
        private $conn;

        // Table
        private $db_table = "phones";

        // Columns
        public $Brand;
        public $Model;
        public $Year;
        public $Price;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getPhones(){
            $sqlQuery = "SELECT Brand, Model, Year, Price FROM " . $this->db_table;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createPhone(){
            $sqlQuery = "INSERT INTO " . $this->db_table . "
            SET
            Brand = :Brand,
            Model = :Model,
            Year = :Year,
            Price = :Price";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->Brand = htmlspecialchars(strip_tags($this->Brand));
            $this->Model = htmlspecialchars(strip_tags($this->Model));
            $this->Year = htmlspecialchars(strip_tags($this->Year));
            $this->Price = htmlspecialchars(strip_tags($this->Price));


            // bind data
            $stmt->bindParam(":Brand", $this->Brand);
            $stmt->bindParam(":Model", $this->Model);
            $stmt->bindParam(":Year", $this->Year);
            $stmt->bindParam(":Price", $this->Price);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSinglePhone(){
            $sqlQuery = "SELECT Brand, Model, Year, Price FROM " . $this->db_table . " WHERE Brand = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->Brand);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->Brand = $dataRow['Brand'];
            $this->Model = $dataRow['Model'];
            $this->Year = $dataRow['Year'];
            $this->Price = $dataRow['Price'];
        }        

        // UPDATE
        public function updatePhone(){
            $sqlQuery = "UPDATE " . $this->db_table . "
            SET
            Model = :Model,
            Year = :Year,
            Price = :Price
            WHERE Brand = :Brand";
        
            $stmt = $this->conn->prepare($sqlQuery);

            $this->Model = htmlspecialchars(strip_tags($this->Model));
            $this->Year = htmlspecialchars(strip_tags($this->Year));
            $this->Price = htmlspecialchars(strip_tags($this->Price));
            $this->Brand = htmlspecialchars(strip_tags($this->Brand));
        
            // bind data
            $stmt->bindParam(":Model", $this->Model);
            $stmt->bindParam(":Year", $this->Year);
            $stmt->bindParam(":Price", $this->Price);
            $stmt->bindParam(":Brand", $this->Brand);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        public function deletePhone(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE Brand = ?";
            $stmt = $this->conn->prepare($sqlQuery);
            $this->Brand = htmlspecialchars(strip_tags($this->Brand));
            $stmt->bindParam(1, $this->Brand);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }

    }
?>

