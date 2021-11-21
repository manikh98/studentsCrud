<?php
ini_set("dispaly_errors", 0);
error_reporting(false);

include_once 'config.php';

$email = $_GET["email"];
$id = isset($_GET["id"]) ? $GET["id"] : "";

$where = "";
if ($id != "") {
    $where = " AND id != $id ";
}

$sql = "SELECT id FROM students_data WHERE email='$email' $where";
$result = $conn->query($sql);
$arr = [];
if ($result->num_rows > 0) {
    echo 0;
    // echo "Email is already taken.";
} else {
    // echo "";
    echo 1;
}
$conn->close();
die;
