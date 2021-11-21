<?php
include_once 'config.php';

$id = $_GET["id"];
$sql = "SELECT * FROM students_data WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$fname = $row["first_name"];
$mname = $row["middle_name"];
$lname = $row["surname"];
$email = $row["email"];
$age = $row["age"];
$gender = $row["gender"];
$country = $row["country_id"];
$state = $row["state_id"];
$city = $row["city"];
$code = $row["zipcode"];
$image = $row["image"];
$currentPage = $_GET["currentPage"];
?>

<head>
    <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="js/css/validationEngine.jquery.css" type="text/css" />
    <!-- <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->
    <script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="js/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        form {
            width: 50%;
        }

        .mt-100 {
            margin-top: 60px !important;
        }

        #emailError {
            color: #ff0000;
        }

        .a {
            text-align: center;
        }


        .formErrorContent {
            min-width: 140px !important;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#editStudentForm").validationEngine();

        });
        var studentCountry = <?php echo $country ?>;
        var studentState = <?php echo $state ?>;
        showCountries(studentCountry);
        stateAjax(studentCountry);

        function showCountries(vs) {

            $.get("ajaxGetCountries.php?studentCountryId=" + studentCountry, function(data, status) {
                $("#country_dropdown").html(data);
            });
        }

        function stateAjax(val) {

            $.get("ajaxGetStates.php?countryId=" + val + "&studentStateId=" + studentState, function(data, status) {
                $("#state_dropdown").html(data);
            });
        }

        function showHint(str) {
            if (str.length == 0) {
                $("#emailError").html("");
                return;
            } else {
                $("#email_ajax_loader").css({
                    "dispaly": "block"
                });
            }
            $.get("getHint.php?email=" + str + "&id=" + '<?php echo $id ?>', function(data, status) {
                if (data == 0) {
                    $("#emailError").html("Email is already taken.");
                } else {
                    $("#emailError").html("");
                }
                $("#email_ajax_loader").css({
                    "dispaly": "none"
                });
            });
        }
    </script>
</head>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="active"><a href="createStudentForm.php">Create</a></li>
            <li><a href="studentsList.php">List</a></li>
        </ul>
    </div>
</nav>

<body>
    <div class="container" style="background-color:lavender;">
        <div class="row mt-100"></div>
        <div class="a">
            <h2>Edit Student</h2>
        </div>
        <form action="editStudentSubmit.php?page=<?php echo $currentPage; ?>" class="form-horizontal" id="editStudentForm" name="myform" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group row">
                    <label for="fname" class="col-sm-4 col-form-label"> First Name: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="fname" name="fname" value="<?php echo $fname; ?>" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mname" class="col-sm-4 col-form-label"> Middle Name: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="mname" name="mname" value="<?php echo $mname; ?>" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-4 col-form-label"> Surname: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="lname" name="lname" value="<?php echo $lname; ?>" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label"> Email: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required,custom[email]] text-input" id="email" name="email" value="<?php echo $email; ?>" onblur="showHint(this.value)">
                            <span id="email_ajax_loader" style="display:none;"><img src="images/loader.gif" /></span>
                            <span id="emailError"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="age" class="col-sm-4 col-form-label"> Age: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyNumber]] text-input" id="age" name="age" value="<?php echo $age; ?>" minlength="1" maxlength="3">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="age" class="col-sm-4 col-form-label"> Gender: </label>
                    <div class="col-sm-4">
                        <div class="form-check">
                            <input type="radio" class="form-check-input validate[required]" name="gender" value="male" <?php if ($gender == "male") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input validate[required]" name="gender" value="female" <?php if ($gender == "female") {
                                                                                                                                echo "checked";
                                                                                                                            } ?>>
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input validate[required]" name="gender" value="other" <?php if ($gender == "other") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-4 col-form-label"> Address: </label><br>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <label for="country" class="col-sm-4 col-form-label">Country</label>
                            <select class="form-control validate[required]" name="country" id="country_dropdown" value="<?php echo $country; ?>" onchange="stateAjax(this.value)"></select>
                        </div>
                        <div class="col-sm-10">
                            <label for="state" class="col-sm-4 col-form-label">State</label>
                            <select class="form-control validate[required]" name="state" id="state_dropdown" value="<?php echo $state; ?>"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-4 col-form-label">City</label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" name="city" id="city" value="<?php echo $city; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postcode" class="col-sm-4 col-form-label"> Zip Code: </label>
                    <div class="col-8">
                        <div class="col-sm-10">
                            <input type="text" class="form-control validate[required, custom[onlyNumber], minSize[5], maxSize[7]] text-input" id="postcode" name="postcode" value="<?php echo $code; ?>" minlength="5" maxlength="7">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-4 col-form-label"> Upload Photo: </label>
                    <div class="col-sm-8">
                        <input type="file" class="form-control-file" name="image" id="image">
                        <img src="<?php echo $image; ?>" height="140" width="140" />
                    </div>
                </div>
                <input type="hidden" value="<?php echo $id; ?>" name="id" id="hiddenId" />
                <input type="submit" class="btn btn-primary" value="Submit" name="submit" id="submit">
            </div>
        </form>
    </div>
</body>