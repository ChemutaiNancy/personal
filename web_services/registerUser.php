<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 13/02/2019
 * Time: 17:48
 */

require_once '../includes/DbOperations.php';
//define an associative array for error msg
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check all values are provided
    if (isset($_POST['first_name'])and
        isset($_POST['middle_name'])and
            isset($_POST['last_name'])and
                isset($_POST['national_id'])and
                    isset($_POST['phone_no'])and
                        isset($_POST['email'])and
                            isset($_POST['password'])){

        $db = new DbOperations();
        $result = $db->createUser($_POST['first_name'],
                                    $_POST['middle_name'],
                                    $_POST['last_name'],
                                    $_POST['national_id'],
                                    $_POST['phone_no'],
                                    $_POST['email'],
                                    $_POST['password']);
        if ($result == 1)
            /*$db->createUser(
            $_POST['first_name'],
            $_POST['middle_name'],
            $_POST['last_name'],
            $_POST['national_id'],
            $_POST['phone_no'],
            $_POST['email'],
            $_POST['password'])*/
        {
            $response['error'] = false;
            $response['message'] = "User registered successfully";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "User not registered, please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "User already exists, please choose a different national ID, phone number and email";
        }


    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);