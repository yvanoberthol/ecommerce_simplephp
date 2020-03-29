<?php
/**
 * Created by PhpStorm.
 * User: Franck
 * Date: 12/01/2020
 * Time: 17:13
 */

class BD_config
{
    static private $host = 'localhost';
    static private $username = 'root';
    static private $password = 'yvano1105';
    static private $bd_name = 'e_commerce_pro';
    public $bd = null;

    public function __construct(){
        if(!$this->bd) {
            try {
                $this->bd = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$bd_name , self::$username, self::$password);
            } catch (PDOException $exception) {
                die('PDO CONNECTION ERROR: ' . $exception->getMessage() . '<br/>');
            }
        }
    }

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTransaction() {
        return $this->bd->beginTransaction();
    }

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit() {
        return $this->bd->commit();
    }

    /**
     * Fetch the SQLSTATE associated with the last operation on the database handle
     *
     * @return string
     */
    public function errorCode() {
        return $this->bd->errorCode();
    }

    /**
     * Fetch extended error information associated with the last operation on the database handle
     *
     * @return array
     */
    public function errorInfo() {
        return $this->bd->errorInfo();
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $statement
     * @return int
     */
    public function exec($statement) {
        return $this->bd->exec($statement);
    }

    /**
     * Retrieve a database connection attribute
     *
     * @param int $attribute
     * @return mixed
     */
    public function getAttribute($attribute) {
        return $this->bd->getAttribute($attribute);
    }

    /**
     * Return an array of available PDO drivers
     *
     * @return array
     */
    public function getAvailableDrivers(){
        return Self::$this->bd->getAvailableDrivers();
    }

    /**
     * Returns the ID of the last inserted row or sequence value
     *
     * @param string $name Name of the sequence object from which the ID should be returned.
     * @return string
     */
    public function lastInsertId($name) {
        return $this->bd->lastInsertId($name);
    }

    /**
     * Prepares a statement for execution and returns a statement object
     *
     * @param string $statement A valid SQL statement for the target database server
     * @param bool $driver_options Array of one or more key=>value pairs to set attribute values for the PDOStatement obj
     *
     * returned
     * @return PDOStatement
     */
    public function prepare ($statement, $driver_options=false) {
        if(!$driver_options) $driver_options=array();
        return $this->bd->prepare($statement, $driver_options);
    }

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $statement
     * @return PDOStatement
     */
    public function query($statement) {
        return $this->bd->query($statement);
    }

    /**
     * Execute query and return all rows in assoc array
     *
     * @param string $statement
     * @return array
     */
    public function queryFetchAllAssoc($statement) {
        return $this->bd->query($statement)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute query and return one row in assoc array
     *
     * @param string $statement
     * @return array
     */
    public function queryFetchRowAssoc($statement) {
        return $this->bd->query($statement)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Execute query and select one column only
     *
     * @param string $statement
     * @return mixed
     */
    public function queryFetchColAssoc($statement) {
        return $this->bd->query($statement)->fetchColumn();
    }

    /**
     * Quotes a string for use in a query
     *
     * @param string $input
     * @param int $parameter_type
     * @return string
     */
    public function quote ($input, $parameter_type=0) {
        return $this->bd->quote($input, $parameter_type);
    }

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack() {
        return $this->bd->rollBack();
    }

    /**
     * Set an attribute
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute($attribute, $value  ) {
        return $this->bd->setAttribute($attribute, $value);
    }
}