<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 13/02/2019
 * Time: 17:09
 */
class DbConnect{
    private $conn;

    function __construct(){//constructor
    }

    function connect(){
        include_once dirname(__FILE__).'/Constants.php';
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        //CHECK FOR AN ERROR
        if (mysqli_connect_errno()){
            echo "Failed to connect to the database".mysqli_connect_errno();//concat error msg
        } else {
            /*echo "Successfully connected to the database";*/
            return $this->conn;
        }
    }
}