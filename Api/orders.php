<?php
header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];


function register_orders($conn)
{
    extract($_POST);
    $data = array();
    $query = "insert into orders(citizen_id,passport_type_id,amount,issuing_authority_id)
    values('$citizen_id', '$passport_type_id', '$amount', '$issuing_authority_id')";

    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "Successfully Registered 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function read_all_orders($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT o.order_id,c.fullname as citizen_name,pt.passport_type,o.amount as passport_price,i.name as issuing_authority,o.status,o.date_ordered FROM orders o JOIN citizens c on o.citizen_id=c.citizen_id JOIN passport_type pt on o.passport_type_id=pt.passport_type_id JOIN issuing_authority i on o.issuing_authority_id=i.issuing_authority_id";
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


function read_all_issuing_authority($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT * from issuing_authority";
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

function read_passport_price($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_passport_price('$passport_type_id')";
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


function get_orders_info($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT * FROM orders where order_id= '$order_id'";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function update_order($conn)
{
    extract($_POST);

    $data = array();

    $query = "UPDATE orders set citizen_id = '$citizen_id', passport_type_id = '$passport_type_id', amount = '$amount', issuing_authority_id = '$issuing_authority_id'  WHERE order_id= '$order_id'";

    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "successfully updated 😂😊😒😎");
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
