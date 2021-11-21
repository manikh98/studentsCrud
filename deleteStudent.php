<?php
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET["id"];

    $conn = new mysqli("localhost", "root", "", "student");

    if ($conn->connect_error) {
        die("connection failed:" . $conn->connect_error);
    }

    $sql = "DELETE FROM students_data WHERE id = '$id'";

    if ($conn->query($sql) == TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record";
    }
    $conn->close();
}
?>