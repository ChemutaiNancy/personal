<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 21/02/2019
 * Time: 16:01
 */
include '..\includes\DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check all values are provided
    if (isset($_POST['route_id'])and
        isset($_POST['travel_date'])and
        isset($_POST['return_ticket'])and
        isset($_POST['no_of_seats'])and
        isset($_POST['pick_up_location'])){

        $db = new DbOperations();
        $result = $db->makeBooking($_POST['route_id'],
            $_POST['travel_date'],
            $_POST['return_ticket'],
            $_POST['no_of_seats'],
            $_POST['pick_up_location']);

        if ($result == 1)
        {
            $response['error'] = false;
            $response['message'] = "Booking made successfully";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Booking not made, please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Booking has been made, please choose a different travel date";
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