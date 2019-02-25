<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 15/02/2019
 * Time: 16:43
 */
require_once '../includes/DbOperations.php';
//define an associative array for error msg
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['phone_no']) and isset($_POST['password'])){
        $db = new DbOperations();
        if ($db->userLogin($_POST['phone_no'], $_POST['password'])){
           $user = $db->getUserByPhoneNo($_POST['phone_no']);

           $response['error'] = false;

           $response['user_id'] = $user['user_id'];
           $response['first_name'] = $user['first_name'];
           $response['middle_name'] = $user['middle_name'];
           $response['last_name'] = $user['last_name'];
           $response['national_id'] = $user['national_id'];
           $response['phone_no'] = $user['phone_no'];
           $response['email'] = $user['email'];

        } else {
            $response['error'] = true;
            $response['message'] = "Invalid phone number or password";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Kindly fill the required fields";
    }
}

echo json_encode($response);