<?php
class Database extends PDO{

    private $stmt;

    public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {
        parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,false); //for debugging
    }

    public function query($query){
        $this->stmt = $this->prepare($query);

    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function results(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function getLastId(){
        return $this->lastInsertId();
    }

    public function beginTransaction(){
        return $this->beginTransaction();
    }

    public function endTransaction(){
        return $this->commit();
    }

    public function cancelTransaction(){
        return $this->rollBack();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }

    //my custom basic commands
    //insert data
    public function insert($table = null, $data = array()){
        $dataString = null;
        foreach($data as $key => $val){
            $dataString .= $key.' = :'.$key.', ';
        }
        $dataString = rtrim($dataString, ', ');
        $sql = 'INSERT INTO '.$table.' SET '.$dataString;
        $this->query($sql);
        foreach($data as $key => $val){
            $this->bind(':'.$key, $val);
        }
        $this->execute();
        return $this->lastInsertId();
    }

    //update
    public function update($table = null, $data = array(), $where = array()){
        $dataString = null;
        $whereString = null;
        foreach($data as $key => $val){
            $dataString .= $key.' = :'.$key.', ';
        }
        $dataString = rtrim($dataString, ', ');

        if(!empty($where)){
            foreach($where as $key => $val){
                $whereString .= ' AND '.$key.' = :'.$key;
            }
            $whereString = ' WHERE '.ltrim($whereString, ' AND ');
        }

        $sql = 'UPDATE '.$table.' SET '.$dataString.$whereString;

        $this->query($sql);
        foreach($data as $key => $val){
            $this->bind(':'.$key, $val);
        }

        foreach($where as $key => $val){
            $this->bind(':'.$key, $val);
        }
        $this->execute();
    }

    //delete
    public function delete($table = null, $data = array()){
        $dataString = null;
        foreach($data as $key => $val){
            $dataString .= ' AND '.$key.' = :'.$key;
        }

        $dataString = ltrim($dataString, ' AND ');
        $sql = 'DELETE FROM '.$table.' WHERE '.$dataString;

        $this->query($sql);
        foreach($data as $key => $val){
            $this->bind(':'.$key, $val);
        }
        $this->execute();
        return $this->lastInsertId();
    }
}

//how to use//
/*
 *  // Include database class
    include 'database.class.php';

    // Define configuration
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "adminadmin123");
    define("DB_NAME", "db_users");
 *
 *
 * Firstly you need to instantiate a new database.
 * $database = new Database();
 *
 * Next we need to write our insert query. Notice how I’m using placeholders instead of the actual data parameters.
 * $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
 *
 * Next we need to bind the data to the placeholders.
 * $database->bind(':fname', 'John');
 * $database->bind(':lname', 'Smith');
 * $database->bind(':age', '24');
 * $database->bind(':gender', 'male');
 *
 * And finally we run execute the statement.
 * $database->execute();
 *
 * Before running the file, echo out the lastInsertId function so you will know that the query successfully ran when viewed in the browser.
 * echo $database->lastInsertId();
 *
 *
 * Insert multiple records using a Transaction
 * The next test we will try is to insert multiple records using a Transaction so that we don’t have to repeat the query.
 *
 * The first thing we need to do is to begin the Transaction.
 * $database->beginTransaction();
 *
 * Next we set the query.
 * $database->query('INSERT INTO mytable (FName, LName, Age, Gender) VALUES (:fname, :lname, :age, :gender)');
 *
 * Next we bind the data to the placeholders.
 * $database->bind(':fname', 'Jenny');
 * $database->bind(':lname', 'Smith');
 * $database->bind(':age', '23');
 * $database->bind(':gender', 'female');
 *
 * And then we execute the statement.
 * $database->execute();
 *
 * Next we bind the second set of data.
 * $database->bind(':fname', 'Jilly');
 * $database->bind(':lname', 'Smith');
 * $database->bind(':age', '25');
 * $database->bind(':gender', 'female');
 *
 * And run the execute method again.
 * $database->execute();
 *
 * Next we echo out the lastInsertId again.
 * echo $database->lastInsertId();
 *
 * And finally we end the transaction
 * $database->endTransaction();
 *
 *
 * SELECTING RECORDS
 * So first we set the query.
 * $database->query('SELECT FName, LName, Age, Gender FROM mytable WHERE LName = :lname');
 * $database->bind(':lname', 'Smith');
 *
 * $rows = $database->results();
 *
 * or
 *
 * $row = $database->single();
 *
 * echo "<pre>";
 * print_r($row);
 * echo "</pre>";
 *
*/