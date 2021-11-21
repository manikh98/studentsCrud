<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $city = $_POST["city"];
    $code = $_POST["postcode"];
    $id = $_POST["id"];
    $currentPage = $_GET["page"];
    $updateImage = "";
    $isError = false;
    $errorHtml = "";
    if (!$fname) {
        $isError = true;
        $errorHtml .= "Please enter firstname<br/>";
    }
    if (!$mname) {
        $isError = true;
        $errorHtml .= "Please enter middlename<br/>";
    }
    if (!$lname) {
        $isError = true;
        $errorHtml .= "Please enter surname<br/>";
    }
    if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
        $isError = true;
        $errorHtml .= "Please provide valid email address<br/>";
    }
    if (!$age) {
        $isError = true;
        $errorHtml .= "Please enter age<br/>";
    }
    if (!$gender) {
        $isError = true;
        $errorHtml .= "Please select gender<br/>";
    }
    if (!$country) {
        $isError = true;
        $errorHtml .= "Please select country<br/>";
    }
    if (!$state) {
        $isError = true;
        $errorHtml .= "Please select state<br/>";
    }
    if (!$city) {
        $isError = true;
        $errorHtml .= "Please enter city<br/>";
    }
    if (!$code) {
        $isError = true;
        $errorHtml .= "Please enter zipcode<br/>";
    }
    if ($isError) {
        echo $errorHtml;
        die;
    }

    if ($_FILES && $_FILES["image"]["tmp_name"]) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        $uploadSuccess = false;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $uploadSuccess = true;
        }
        if ($check && $uploadSuccess) {
            $dbFilePath = $basePath . $targetFile;
            $updateImage = ", image='$dbFilePath'";
        }
    }
    $sqll = "UPDATE students_data SET first_name='$fname', middle_name='$mname', surname='$lname', email='$email', age='$age', gender='$gender', country_id=$country , state_id=$state, city='$city', zipcode='$code' $updateImage WHERE id='$id'";
    $res = mysqli_query($conn, $sqll);
    if (!$res) {
        echo mysqli_error($conn);
        die;
    }
    header('Location: '.$basePath.'studentsList.php?page=' . $currentPage);
    die;
}
$conn->close();
