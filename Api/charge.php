<?php
header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];

function register_charge($conn)
{
    extract($_POST);
    $data = array();
    $query = "CALL charge('$month', '$year', '$description', '$Acount_id', '$user_id')";

    $result = $conn->query($query);


    if ($result) {

        $row = $result->fetch_assoc();
        if ($row['msg'] == 'Deny') {
            $data = array("status" => false, "data" => "Insuficance Balance😜");
        } elseif ($row['msg'] == 'Registered') {
            $data = array("status" => true, "data" => "transaction successfully ✅");
        } elseif ($row['msg'] == 'NOt') {
            $data = array("status" => false, "data" => "Horay Ayaa loogu dalacay lacagta bishaan ❌");
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_all_charge($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT * from charge order by charge_id
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

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action($conn);
} else {
    echo json_encode(array("status" => false, "data" => "Action Required....."));
}
