<?php
header("content-type: application/json");
include '../config/conn.php';
// $action = $_POST['action'];

function register_passport_info($conn)
{
    extract($_POST);
    $data = array();
    $new_id = generate($conn);
    $query = "insert into passport_information(passport_name,passport_type_id, Passport_Number, price)
    values('$passport_name','$pasport_type_id','$new_id', '$price')";

    $result = $conn->query($query);


    if ($result) {

        //  $row= $result->fetch_assoc();

        $data = array("status" => true, "data" => "Registered succesfully 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_passport_info($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT * from passport_information";
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

function read_passport_type($conn)
{
    $data = array();
    $array_data = array();
    $query = "select * from passport_type";
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

function get_passport_info($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT * FROM passport_information where passport_id= '$passport_id'";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function update_passport_info($conn)
{
    extract($_POST);

    $data = array();

    $query = "UPDATE passport_information set passport_name = '$passport_name', passport_type_id = '$pasport_type_id', price = '$price' WHERE passport_id= '$passport_id'";

    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "successfully updated 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function generate($conn)
{
    $new_id = '';
    $data = array();
    $array_data = array();
    $query = "SELECT * FROM `passport_information` order by passport_information.passport_id DESC limit 1";
    $result = $conn->query($query);


    if ($result) {
        $num_rows = $result->num_rows;

        if ($num_rows > 0) {
            $row = $result->fetch_assoc();

            $new_id = ++$row['Passport_Number'];
        } else {

            $new_id = "PAS001";
        }
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    return $new_id;
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $action($conn);
} else {
    echo json_encode(array("status" => false, "data" => "Action Required....."));
}
