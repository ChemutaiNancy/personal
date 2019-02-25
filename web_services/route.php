<?php
/**
 * Created by PhpStorm.
 * User: Chemutai
 * Date: 16/01/2019
 * Time: 14:41
 */

include '../includes/DbOperations.php';
$route = [];

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $db = new DbOperations();

    $sql = "select * from route";

    $result = mysqli_query($db->getDb(), $sql);

    while ($row = mysqli_fetch_assoc($result)){
        $route[]=$row;
    }
}

header("Content-type:application/json");
echo json_encode($route);