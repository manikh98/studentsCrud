<?php
require_once("config.php");
$countryId = $_GET['countryId'];
$stateId = isset($_GET["studentStateId"]) ? $_GET["studentStateId"] : "";
$result = mysqli_query($conn, "SELECT * FROM states WHERE country_id='$countryId'");
$options = "<option value=''>select state</option>";
while ($row = mysqli_fetch_array($result)) {
    $selected = "";
    if ($stateId == $row["id"]) {
        $selected = "selected='selected'";
    }
    $options = $options . "<option " . $selected . " value='" . $row["id"] . "'>" . $row["id"] . " " . $row["name"] . "</option>";
}
echo  $options;
die;
