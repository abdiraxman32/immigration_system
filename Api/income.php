<?php

header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];


function get_total_income($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT  sum(balance) as total from account";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function get_total_expense($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT  sum(Amount) as total from charge";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}




function get_all_employee($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "select count(employe_id) as employee from employe";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function get_all_users($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "select count(id) as users  from users";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
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


function read__citizen_completed($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT c.fullname as citizen_name,c.phone,c.gender,pt.passport_type,o.amount,o.status,o.date_ordered from orders o JOIN citizens c on o.citizen_id=c.citizen_id JOIN passport_type pt on o.passport_type_id=pt.passport_type_id  WHERE o.status='completed';; 
   ";
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
