<?php
 
class DB {

    private $server = "localhost";
    private $username = "root";
    private $password= "";
    private $dbname = "schedlr";

   

    /**Documentation
     * DBconnection() function -
     * Database connection;
     * @return mysqli Datbase connection;
     */
    protected function DBconnection() {
        $conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        return $conn;
    }
    /**Documentation
     * DBclose() function -
     * close database connection;
     * @param mysqli $conn - Database connection.
     * @return void
     */
    protected function DBclose($conn) {
        $conn->close();
    }

    /**Documentation
     * create() function -
     * Insert Data from Database.
     *
     * @param string $tablename Database table name.
     * @param array $insertData column name and value of column. example data array("column"=>"value").
     * @return string try-catch error in Database , True if successfuly inserted.
     */
    protected function create(string $tablename ,  array $insertData ){
        
        try{

            $conn = $this->DBconnection();
            $column = "";
            $value = "";

            $escapeInsertData = array_map(function($value)use($conn){
                return mysqli_real_escape_string($conn, $value);
            }, $insertData);

            foreach($escapeInsertData as $columns=>$values ){
                
                if($columns === array_key_last($escapeInsertData)){
                    $column .= $columns;
                    $value .= (is_numeric($values))? "{$values}" : "'{$values}' ";
                }
                else{
                    $column .= "{$columns}, ";
                    $value .= (is_numeric($values))? "{$values}, " : "'{$values}', ";
                }

            }

            $sql = "INSERT INTO {$tablename} ({$column})VALUES($value) ";
            $result = $conn->query($sql);
            if($result){ $output = true; }
            

        }catch(mysqli_sql_exception $mysqli_error){
            $output =  $mysqli_error;
        }

        $this->DBclose($conn);
        return $output;
    }

    /** Documentation
     * read() function - 
     * read Data from Database.
     *
     * @param string $tablename - Database table name.
     * @param array $searchData - column name and value of column. example data --- array("column"=>"value") .
     * this parameter is optional if parameter is null meaning all data from database will be read.
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string try-catch error in Database , True if successfuly inserted.
     */
    protected function read(string $tablename , array $searchData = null , string $logicalOperator = null){
        try{
            $conn = $this->DBconnection();

            $dataCollection = array();

            if(!empty($searchData) && is_array($searchData)){
                $search = $this->DataQueryComparison($searchData, $conn , $logicalOperator);
                $sql = "SELECT * FROM {$tablename} WHERE {$search} ";
            }
            else{
                $sql = "SELECT * FROM {$tablename}";
            }

            $result = $conn->query($sql);
            if($result->num_rows > 0){
                while($row= $result->fetch_assoc()){
                    $dataCollection[] = $row;
                }
                $output = $dataCollection; // collection of data.
            }
            else{
                $output = false; //no data found
            }
        }
        catch(mysqli_sql_exception $mysqli_error){
            $output = $mysqli_error;
        }

        $this->DBclose($conn);
        return  $output;
    }

    /** Documentation
     * update() function - 
     * update Data from Database.
     *
     * @param string $tablename - Database table name.
     * @param array $updateData - set of data that you want to update to database. ex array("column"=>"value").
     * @param array $searchData - column name and value of column. example data --- array("column"=>"value") .
     * this parameter is optional if parameter is null meaning all data from database will be read.
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string try-catch error in Database , True if successfuly updated.
     */
    protected function update(string $tablename , array $updateData , array $searchData, string $logicalOperator = null){

        try{
            $conn = $this->DBconnection();

            $updateDataSet = $this->DataQueryEqual($updateData , $conn);
            $search = $this->DataQueryComparison($searchData, $conn, $logicalOperator);

            $sql = "UPDATE {$tablename} SET {$updateDataSet} WHERE {$search} ";
            $result = $conn->query($sql);
            if($result){ $output = true; }
        }
        catch(mysqli_sql_exception $mysqli_error){
            $output = $mysqli_error;
        }

        $this->DBclose($conn);
        return $output;

    }

    /** Documentation
     * delete() function - 
     * this is not actually delete data from database it is only update the value of column userDelete  to 0.
     *
     * @param string $tablename - Database table name.
     * @param array $searchData - column name and value of column. example data --- array("column"=>"value") .
     * this parameter is optional if parameter is null meaning all data from database will be read.
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string try-catch error in Database , True if successfuly updated.
     */
    protected function delete(string $tablename , array $searchData , $logicalOperator = null){
        try{

            $conn = $this->DBconnection();
            $logicalOperator = $this->getLogicalComparision($logicalOperator);
            $search = $this->DataQueryComparison($searchData, $conn , $logicalOperator);
            $sql = "UPDATE {$tablename} SET userDeleted = 0 WHERE {$search} ";
            $result = $conn->query($sql);
            if($result){ $output = true; }

        }
        catch(mysqli_sql_exception $mysqli_error ){
            $output = $mysqli_error;
        }

        $this->DBclose($conn);
        return $output;
    }

    /** Documentation
     * DataCheck() function - 
     * this function search in database if the value is exist.
     * @param string $tablename - Database table name.
     * @param array $searchData - column name and value of column. example data --- array("column"=>"value") .
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string try-catch error in Database , True  data found False data not exist.
     */
    protected function DataCheck(string $tablename , array $searchData, string $logicalOperator = null ){
        
        try{
            $conn = $this->DBconnection();

            $search = $this->DataQueryComparison($searchData , $conn, $logicalOperator);

            $sql = "SELECT * FROM {$tablename} WHERE {$search}";
            $result = $conn->query($sql);

            return ($result->num_rows > 0) ? true : false;

        }
        catch(mysqli_sql_exception $mysqli_error){
            $output = $mysqli_error;
        }

        $this->DBclose($conn);
        return $output;
    }


    /** Documentation
     * DataQueryComparison() function - 
     * @param array $array - collection of data. ex. data array("column"=>"value", "column"=>0).
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string collection of string column and value. ex. output column = '' AND column = 0
    */ 
    protected function DataQueryComparison(array $array  , mysqli $conn , string $logicalOperator = null){
        $logicalOperator = $this->getLogicalComparision($logicalOperator);

        $output = "";

        $escapeData = array_map(function($value)use($conn){
            return mysqli_real_escape_string($conn, $value);
        }, $array);

        foreach($escapeData as $columns=>$values){
            if($columns === array_key_last($escapeData)){
                $output .= (is_numeric($values))? "{$columns} = {$values}" : "{$columns} = '{$values}' ";
            }
            else{
                $output .= (is_numeric($values))? "{$columns} = {$values} {$logicalOperator} " : "{$columns} = '{$values}' {$logicalOperator} ";
            }
        }

        return $output;
    }

    /** Documentation
     * DataQueryEqual() function - 
     * @param array $array - collection of data. ex. data array("column"=>"value", "column"=>0).
     * @return string collection of string column and value. ex. output column = 'value' or column = 'value' , colum = 0 
    */ 
    protected function DataQueryEqual(array $array  , mysqli $conn){

        $output = "";

        $escapeData = array_map(function($value)use($conn){
            return mysqli_real_escape_string($conn, $value);
        }, $array);

        foreach($escapeData as $columns=>$values){
            if($columns === array_key_last($escapeData)){
                $output .= (is_numeric($values))? "{$columns} = {$values}" : "{$columns} = '{$values}' ";
            }
            else{
                $output .= (is_numeric($values))? "{$columns} = {$values}, " : "{$columns} = '{$values}', ";
            }
        }

        return $output;
    }

    /** Documentation
     * DataQueryInline() function - 
     * @param array $array - collection of data. ex. data array("column"=>"value", "column"=>0).
     * @return string collection of string column and value. ex. output column , column   or value , value
     */ 
    protected function DataQueryInline(array $array  , mysqli $conn){

        $output = "";

        $escapeData = array_map(function($value)use($conn){
            return mysqli_real_escape_string($conn, $value);
        }, $array);

        foreach($escapeData as $columns=>$values){
            if($columns === array_key_last($escapeData)){
                $output .= (is_numeric($values))? "{$columns} = {$values}" : "{$columns} = '{$values}' ";
            }
            else{
                $output .= (is_numeric($values))? "{$columns} = {$values}, " : "{$columns} = '{$values}', ";
            }
        }

        return $output;
    }

    /** Documentation
     * getLogicalComparision() function - 
     * this function check if the $logicalOperator variable contain AND or OR value. If null the default value is AND.
     * @param string $logicalOperator - This is logical operator either AND or OR. THe default value is AND.
     * @return string return either AND or OR.
     */
    protected function getLogicalComparision($logicalOperator){
        if($logicalOperator === "AND" || $logicalOperator === "and" ){
            return "AND";
        }
        else if($logicalOperator === "OR" || $logicalOperator === "or" ){
            return "OR";
        }
        else{
            return "AND";
        }
    }

}
?>