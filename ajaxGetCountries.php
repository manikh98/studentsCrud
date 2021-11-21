<?php
require_once("config.php");
$countryId=isset($_GET["studentCountryId"]) ? $_GET["studentCountryId"] : "";
$result = mysqli_query($conn, "SELECT * FROM countries");
$options = "<option value=''>select country</option>";
while ($row = mysqli_fetch_array($result)) {
    $selected = "";
    if ($countryId == $row["id"]) {
        $selected = "selected='selected'";
    }
    $options = $options . "<option " . $selected . " value='" . $row["id"] . "'>" . $row["id"] . " " . $row["name"] . "</option>";
}
echo  $options;
die;
