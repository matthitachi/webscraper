<?php
/**
 * Created by PhpStorm.
 * User: ITACHI
 * Date: 11/12/2018
 * Time: 12:13 PM
 */

class database
{
public $arrayFile = array();
public $connection = null;
public $table = null;

public function __construct($server, $username, $password, $database)
{
    print_r('connecting to database......<br/>');
    $this->init_db($server, $username, $password, $database);
}

    public function init_db($server, $username, $password, $database){
    try {
        $this->connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Connected successfully";
        print_r('database connected successfully......<br/>');
    }
    catch(PDOException $e)
    {

        print_r("Connection failed: " . $e->getMessage()."<br/>" );
    }

}


public function column($name, $type, $length=""){
    if($type != 'int' && $type != 'varchar'){
        $length = '';
    }
$column = array($name, $type, $length);
array_push($this->arrayFile, $column);
}
public function createTable($name){
    $this->table = $name;
    print_r('Creating tables......<br/>');
    $begin_sql = "DROP TABLE IF EXISTS $name; Create Table $name ( id int(50) not null auto_increment primary key,";
    $end_sql = ")";

    foreach ($this->arrayFile as $val){
        if(strtolower($val[1]) == 'int' || strtolower($val[1]) == 'varchar'){
            $begin_sql .= " {$val[0]} {$val[1]}(".(string)$val[2]."),";
        }else{
            $begin_sql .= " $val[0] $val[1], ";
        }

    }
    $sql= rtrim($begin_sql,', ').$end_sql;
    try {
        $stmt = $this->connection->prepare($sql);
        if($stmt->execute()){
            print_r('Tables created successfully......<br/>');
        }else{
            print_r('Error creating tables in database......<br/>');
        }

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
        die();
    }
    
}

public function insert($data, $row){
    if($this->table == null){
        print_r('Create table first');
    }
    $sql = "insert into $this->table ";
    $value = "";
    $columns = "";
    $array = [];
    foreach ($data as $val){
    $columns .="$val[1], ";
    $value .= "?, ";
    array_push($array, $val[0]);
    }
    $columns = "(".rtrim($columns, ', ').") ";
    $value = "values (".rtrim($value, ', ').")";
    $sql .= $columns.$value;
    try {
        $stmt = $this->connection->prepare($sql);
        if($stmt->execute($array)){
            print_r("Row {$row} inserted successfully......<br/>");
        }else{
            print_r('Error inserting rows in database......<br/>');
        }

    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
        die();
    }

}
}