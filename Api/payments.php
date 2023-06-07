<?php
header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];


function register_payments($conn)
{
    extract($_POST);
    $data = array();
    $query = "INSERT INTO payment (citizen_id, amount,Account_id,payment_method_id)
     values('$cittizen_id','$amount','$Accounttt_id','$payment_method_id')";

    $result = $conn->query($query);


    if ($result) {


        $data = array("status" => true, "data" => "successfully Registered 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_all_payments($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT p.payment_id,c.fullname as citizen_name,p.amount,ac.bank_name,pm.name as method_name from payment p JOIN citizens c on p.citizen_id=c.citizen_id JOIN account ac on p.Account_id=ac.Account_id JOIN payment_method pm on p.payment_method_id=pm.p_method_id";
    $result = $conn->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function read_payment_price($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_payment_price('$citizen_id')";
    $result = $conn->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_all_citizen_name($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT c.citizen_id,c.fullname from orders o JOIN citizens c on o.citizen_id=c.citizen_id";
    $result = $conn->query($query);


    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $array_data[] = $row;
        }
        $data = array("status" => true, "data" => $array_data);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action($conn);
} else {
    echo json_encode(array("status" => false, "data" => "Action Required....."));
}
