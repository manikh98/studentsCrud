<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Create Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="js/css/validationEngine.jquery.css" type="text/css" />
    <script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="js/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
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
            $("#studentForm").validationEngine({
                showArrowOnRadioAndCheckbox: true,
                promptPosition: "centerRight"
            });

        });

        showCountries();

        function showCountries() {
            var country_id = this.value;
            $.ajax({
                url: "ajaxGetCountries.php",
                method: "GET",
                data: {
                    country_id: country_id
                },
                success: function(ress) {
                    $("#country_dropdown").html(ress);
                }

            });
            $.get("ajaxGetCountries.php", function(data, status) {

                $("#country_dropdown").html(data);
            });

        }

        function stateAjax(val) {
            var state_id = this.value;
            $.ajax({
                url: "ajaxGetStates.php",
                method: "GET",
                data: {
                    state_id: state_id
                },
                success: function(resp) {
                    $("#state_dropdown").html(resp);
                }
            });

            $.get("ajaxGetStates.php?countryId=" + val, function(data, status) {

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
            $.get("getHint.php?email=" + str, function(data, status) {
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
            <h2>Add Student</h2>
        </div>
        <div class="">
            <form action="studentCreated.php" class="form-horizontal" id="studentForm" name="myform" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="fname" class="col-sm-2 col-form-label"> First Name: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="fname" name="fname" value="" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mname" class="col-sm-2 col-form-label"> Middle Name: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="mname" name="mname" value="" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-2 col-form-label"> Surname: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" id="lname" name="lname" value="" minlength="2" maxlength="10">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label"> Email: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required,custom[email]] text-input" id="email" name="email" value="" onblur="showHint(this.value)">
                            <span id="email_ajax_loader" style="display:none;"><img src="images/loader.gif" /></span>
                            <span id="emailError"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="age" class="col-sm-2 col-form-label"> Age: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyNumber]] text-input" id="age" name="age" value="" minlength="1" maxlength="3">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="age" class="col-sm-2 col-form-label"> Gender: </label>
                    <div class="col-sm-2">
                        <div class="form-check">
                            <input type="radio" id="male" class="form-check-input validate[required]" name="gender" value="male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="female" class="form-check-input validate[required]" name="gender" value="female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="other" class="form-check-input validate[required]" name="gender" value="other">
                            <label class="form-check-label" for="other">Other</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label"> Address: </label><br>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <label for="country" class="col-sm-2 col-form-label">Country</label>
                            <select class="form-control validate[required]" name="country" id="country_dropdown" onchange="stateAjax(this.value)"></select>
                        </div>
                        <div class="col-sm-4">
                            <label for="state" class="col-sm-2 col-form-label">State</label>
                            <select class="form-control validate[required]" name="state" id="state_dropdown"></select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-sm-2 col-form-label">City</label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyLetter]] text-input" name="city" id="city">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="postcode" class="col-sm-2 col-form-label"> Zip Code: </label>
                    <div class="col-8">
                        <div class="col-sm-4">
                            <input type="text" class="form-control validate[required, custom[onlyNumber], minSize[5], maxSize[7]] text-input" id="postcode" name="postcode" minlength="5" maxlength="7">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-sm-2 col-form-label"> Upload Photo: </label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                </div>

                <input type="submit" class="btn btn-primary" value="Submit" name="submit" id="submit">
            </form>
        </div>
    </div>
</body>

</html>