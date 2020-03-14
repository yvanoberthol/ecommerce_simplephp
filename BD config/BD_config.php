<?php
/**
 * Created by PhpStorm.
 * User: Franck
 * Date: 12/01/2020
 * Time: 17:13
 */

class BD_config
{
private $host = 'localhost';
private $username = 'root';
private $password = 'yvano1105';
private $bd_name = 'e_commerce_pro';
public $bd = null;

public function __construct(){

    try{
        $this->bd = new PDO('mysql:host='.$this->host.';dbname='.$this->bd_name, $this->username,$this->password);
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }

    return $this->bd;
}



}