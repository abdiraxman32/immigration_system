<?php
header("content-type: application/json");
include '..//config/conn.php';
// $action = $_POST['action'];


function register_employe($conn)
{
    extract($_POST);
    $data = array();
    $query = "insert into employe(fullname,email,tell,city,state,job_id)
    values('$fullname', '$email', '$tell', '$city', '$state', '$job_id')";

    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "Successfully Registered 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function read_employe_statement($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "CALL read_employe_statement('$tellphone')";
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



function read_all_employe($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT e.employe_id as ID,e.fullname,e.email,e.tell,e.city,e.state,j.job_name as job,j.salary from employe e JOIN jobs j on e.job_id=j.job_id";
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

function read_job($conn)
{
    $data = array();
    $array_data = array();
    $query = "SELECT * from jobs";
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



function get_employe_info($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "SELECT * FROM employe where employe_id= '$employe_id'";
    $result = $conn->query($query);


    if ($result) {
        $row = $result->fetch_assoc();

        $data = array("status" => true, "data" => $row);
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}




function update_employe($conn)
{
    extract($_POST);

    $data = array();

    $query = "UPDATE employe set fullname = '$fullname', email = '$email', tell = '$tell', city = '$city', state= '$state', job_id='$job_id'  WHERE employe_id = '$employe_id'";

    $result = $conn->query($query);


    if ($result) {

        $data = array("status" => true, "data" => "successfully updated 😂😊😒😎");
    } else {
        $data = array("status" => false, "data" => $conn->error);
    }

    echo json_encode($data);
}


function Delete_employe($conn)
{
    extract($_POST);
    $data = array();
    $array_data = array();
    $query = "DELETE FROM employe where employe_id= '$employe_id'";
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
