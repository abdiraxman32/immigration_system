<?php
header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];


function register_released_passport($conn)
{
    extract($_POST);
    $data = array();
    $query = "INSERT INTO release_passport (citizen_id, passport_type_id,issuing_date,expire_date)
     values('$Citizen_id','$passport_type_id','$issuing_date','$expire_date')";

    $result = $conn->query($query);


    if ($result) {


        $data = array("status" => true, "data" => "successfully Registered 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_all_released($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT r.release_id,c.fullname as citizen_name,r.passport_type_id as passport_type,r.issuing_date,r.expire_date from release_passport r JOIN citizens c on r.citizen_id=c.citizen_id";
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


function read_passport($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL released_passport('$citizen_id')";
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

function read_all_orders_name($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT c.citizen_id,c.fullname from payment p JOIN citizens c on p.citizen_id=c.citizen_id";
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
