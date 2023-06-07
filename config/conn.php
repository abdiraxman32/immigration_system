<?php

$conn = new mysqli("localhost", "root", "", "immigration_db");

if ($conn->connect_error) {
    echo $conn->error;
}
