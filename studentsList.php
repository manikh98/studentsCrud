<!DOCTYPE html>
<html>

<head>
    <script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="js/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="lightbox.min.css">
    <style>
        .a {
            text-align: center;
        }

        .list {
            display: inline-block;
        }

        .list a {
            font-weight: bold;
            font-size: 16px;
            color: black;
            float: left;
            padding: 6px 14px;
            text-decoration: none;
            border: 1px solid black;
            margin: 5px;
        }

        .list a.active {
            background-color: rgba(175, 201, 244, 0.97);
        }

        .list a:hover:not(.active) {
            background-color: #87ceeb;
        }
    </style>

    <script type="text/javascript">
        function deleteStudent(id) {
            var text;
            var z = confirm("Are you want to delete this student?");
            if (z == true) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText);
                        document.getElementById(id);
                        //$("#id");
                        var element = document.getElementById(id);
                        //var element=$("#id");
                        element.parentNode.removeChild(element);
                    }
                }
                xmlhttp.open("GET", "deleteStudent.php?id=" + id, true);
                xmlhttp.send();
            } else {
                console.log("No");
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="a">
            <h2>Students List</h2>
        </div>
        <?php
        include_once 'config.php';
        $limit = $perPageItems;
        $page_number = 1;
        if (isset($_GET["page"])) {
            $page_number  = $_GET["page"];
        } else {
            $page_number = 1;
        }
        $initial_page = ($page_number - 1) * $limit;
        $result = mysqli_query($conn, "SELECT st.*,c.name as countryName,s.name as stateName FROM students_data st LEFT JOIN countries c ON st.country_id=c.id LEFT JOIN states s ON st.state_id=s.id GROUP BY st.`id` LIMIT $initial_page, $limit");
        if (!$result) {
            echo mysqli_error($conn);
            die;
        }
        if (mysqli_num_rows($result) > 0) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Zip Code</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr id="<?php echo $row["id"]; ?>">
                            <th scope="row"><?php echo $row["id"]; ?></th>
                            <td><?php echo $row["first_name"]; ?></td>
                            <td><?php echo $row["middle_name"]; ?></td>
                            <td><?php echo $row["surname"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["age"]; ?></td>
                            <td><?php echo $row["gender"]; ?></td>
                            <td><?php echo $row["countryName"]; ?></td>
                            <td><?php echo $row["stateName"]; ?></td>
                            <td><?php echo $row["city"]; ?></td>
                            <td><?php echo $row["zipcode"] ?></td>
                            <td><?php if ($row["image"]) { ?><image height="80" width="80" src="<?php echo $row["image"]; ?>" alt="studentFace"></image><?php } ?></td>
                            <td><a class="btn btn-primary" href="editStudentForm.php?id=<?php echo $row["id"] ?>&currentPage=<?php echo $page_number; ?>">Edit</a></td>
                            <td><span class="btn btn-primary" style="cursor:pointer;" onClick="deleteStudent(<?php echo $row["id"]; ?>)">Delete</span></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <div class="list">
            <?php
            $getQuery = "SELECT COUNT(*) FROM students_data";
            $result = mysqli_query($conn, $getQuery);
            $row = mysqli_fetch_row($result);
            $total_rows = $row[0];
            $total_pages = ceil($total_rows / $limit);
            $pageURL = "";
            if ($page_number >= 2) {
                echo "<a href='studentsList.php?page=" . ($page_number - 1) . "'> Prev</a>";
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page_number) {
                    $pageURL .= "<a class = 'active' href='studentsList.php?page=" . $i . "'>" . $i . " </a>";
                } else {
                    $pageURL .= "<a href='studentsList.php?page=" . $i . "'>" . $i . " </a>";
                }
            };
            echo $pageURL;
            if ($page_number < $total_pages) {
                echo "<a href='studentsList.php?page=" . ($page_number + 1) . "'>  Next </a>";
            }

            ?>
        </div>
    </div>
</body>

</html>