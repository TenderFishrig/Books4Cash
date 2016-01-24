<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24/01/2016
 * Time: 13:57
 */
class DBCommunication
{
    private $host="localhost";
    private $dbname="wehope";
    private $login="wehope";
    private $password="l4ndofg10ry";
    private $conn;
    private $stmt;
    private $error;

    /**
     * DBCommunication constructor.
     * @param string $host
     */
    public function __construct()
    {
        try
        {
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->login, $this->password, $options);
        }
        catch (PDOException $exception)
        {
            $this->error = $exception->getMessage();
        }
    }

    public function beginTransaction(){
        return $this->conn->beginTransaction();
    }

    public function endTransaction(){
        return $this->conn->commit();
    }

    public function cancelTransaction(){
        return $this->conn->rollBack();
    }

    public function prepQuery($query){
        $this->stmt=$this->conn->prepare($query);
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
        $this->stmt->bindValue(":$param",$value,$type);
    }

    function bindArrayValue($array, $typeArray = false)
    {
            foreach($array as $key => $value)
            {
                if($typeArray)
                    $this->stmt->bindValue(":$key",$value,$typeArray[$key]);
                else
                {
                    if(is_int($value))
                        $param = PDO::PARAM_INT;
                    elseif(is_bool($value))
                        $param = PDO::PARAM_BOOL;
                    elseif(is_null($value))
                        $param = PDO::PARAM_NULL;
                    elseif(is_string($value))
                        $param = PDO::PARAM_STR;
                    else
                        $param = FALSE;

                    if($param)
                        $this->stmt->bindValue(":$key",$value,$param);
                }
            }
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultset(){
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

    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
}