<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 13/02/2019
 * Time: 17:25
 */
class DbOperations{
    private $conn;

    function __construct(){
        require_once dirname(__FILE__).'/DbConnect.php';
        $db = new DbConnect();//create DbConnect object
        //initialize conn
        $this->conn = $db->connect();
    }

    //CREATE
    public function createUser($first_name, $middle_name, $last_name, $national_id, $phone_no, $email, $pass){
        if ($this->isUserExists($national_id, $phone_no, $email)){
            return 0;
        } else {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `national_id`, `phone_no`, `email`, `password`) 
                    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);");
            $stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $national_id, $phone_no, $email, $password);
            if ($stmt->execute()){
                /*return true;//user is created*/
                return 1;
            } else {
                /*return false;*/
                return 2;
            }
        }
    }

    public function userLogin($phone_no, $pass){
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE phone_no = ? and password = ?");
        $stmt->bind_param("ss", $phone_no,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public  function getUserByPhoneNo($phone_no){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE phone_no = ?");
        $stmt->bind_param("s",$phone_no);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();//converts result in to associative array
    }

    private function isUserExists($national_id, $phone_no, $email){
        $stmt = $this->conn->prepare("SELECT user_id FROM users where national_id = ? OR phone_no = ? OR email = ?");
        $stmt->bind_param("sss", $national_id, $phone_no, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getDb(){
        return$this->conn;
    }

    public function makeBooking($route_id, $travel_date,  $return_ticket, $no_of_seats, $pick_up_location){

        if ($this->isBookingExists($route_id, $travel_date)){
            return 0;
        } else{
            $stmt = $this->conn->prepare("INSERT INTO `booking_details` (`book_id`,`route_id`, `travel_date`, `return_ticket`, `no_of_seats`, `pick_up_location`) 
                    VALUES (NULL, ?, ?, ?, ?, ?);");
            $stmt->bind_param("sssss", $route_id, $travel_date, $return_ticket, $no_of_seats, $pick_up_location);
            if ($stmt->execute()){
                /*return true;//user is created*/
                /*$response['error'] = false;
                $response['message'] = "Booking successfully";*/
                return 1;
            } else {
                /*return false;*/
              /*  $response['error'] = false;
                $response['message'] = "Booking not successful, please try again";*/
              return 2;
            }
        }


    }

    private function isBookingExists($route_id, $travel_date){
        $stmt = $this->conn->prepare("SELECT book_id FROM booking_details WHERE $route_id = ? OR $travel_date = ?");
        $stmt->bind_param("ss", $route_id, $travel_date);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    /*private function forgotPassword($phone_no, $password){
        $stmt = $this->conn->prepare("UPDATE `users` SET `password`= $password WHERE phone_no = $phone_no");
        $stmt->bind_param("ss", $phone_no, $password);
        $stmt->execute();
    }*/
}