<?php

header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];
function register_citizens($conn)
{
    extract($_POST);
    $data = array();
    $query = "INSERT INTO citizens (fullname, phone, gender,address,city,place_of_brith,date_of_brith, nationaty)
     values('$fullname','$phone', '$gender','$address', '$city','$place_of_brith', '$date_of_brith', '$nationaty')";

    $result = $conn->query($query);


    if ($result) {


        $data = array("status" => true, "data" => "successfully Registered 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function read_all_citizens($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT c.citizen_id,c.fullname,c.phone,c.gender,c.address,c.city,c.place_of_brith,c.date_of_brith,c.nationaty from citizens c";
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

function read_citizen_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_citizen_statement('$tellphone')";
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

function read_citizen_pending_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_all_citizen_pending";
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

function read_citizen_paid_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_citizen_paid('$tellphone')";
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




function get_citizen_info($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT *FROM citizens where citizen_id= '$citizen_id'";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function update_citizens($conn)
{
    extract($_POST);

    $data = array();

    $query = "UPDATE citizens set fullname = '$fullname', phone = '$phone', gender = '$gender',address = '$address',city = '$city',place_of_brith = '$place_of_brith', date_of_brith= '$date_of_brith', nationaty= '$nationaty' WHERE citizen_id = '$citizen_id'";


    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "successfully updated 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}

function Delete_citizens($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "DELETE FROM citizens where citizen_id= '$citizen_id'";
    $result = $conn->query($query);


    if ($result) {


        $data = array("status" => true, "data" => "successfully Deleted😎");
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
