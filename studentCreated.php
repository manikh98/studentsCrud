<?php
include_once 'config.php';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = test_input($_POST["fname"]);
    $mname = test_input($_POST["mname"]);
    $lname = test_input($_POST["lname"]);
    $email = test_input($_POST["email"]);
    $age = test_input($_POST["age"]);
    $gender = test_input($_POST["gender"]);
    $country = test_input($_POST["country"]);
    $state = test_input($_POST["state"]);
    $city = test_input($_POST["city"]);
    $code = test_input($_POST["postcode"]);
    $dbFilePath = "";
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
    if (isset($_FILES) && count($_FILES) > 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check == true) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        }
        $dbFilePath = $basePath . $targetFile;
    }

    $sql = "INSERT INTO students_data (first_name,middle_name,surname,email,age,gender,country_id,state_id,city,zipcode,image)
VALUES ('$fname','$mname','$lname','$email','$age','$gender', '$country', '$state','$city','$code','$dbFilePath')";

    if ($conn->query($sql) === TRUE) {
        //echo "success";
        header('Location: ' . $basePath . 'studentsList.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

die;
