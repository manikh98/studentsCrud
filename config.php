<?php
$serverName = "localhost";
$userName = "root";
$dbPassword = "";
$tableName = "students_data";
$dbName = "student";
$perPageItems = 10;

$basePath = "http://localhost/students/";

$conn = new mysqli($serverName, $userName, $dbPassword, $dbName );
if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
}
